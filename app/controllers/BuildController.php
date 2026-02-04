<?php

require_once BASE_PATH . 'app/controllers/BaseController.php';

class BuildController extends BaseController
{
    protected $productModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->productModel = new Product($pdo);
    }

    public function index()
    {
        $categories = [
            'CPU', 'GPU', 'Motherboard', 'RAM', 'Storage', 'PSU', 'Case'
        ];

        $components = [];
        foreach ($categories as $category) {
            $components[$category] = $this->productModel->getProductsByCategory($category);
        }

        $data = [
            'title' => 'Build Your PC & Get a Rating',
            'components' => $components
        ];

        $this->view('build/index', $data);
    }

    public function getRating()
    {
        header('Content-Type: application/json');
        $selectedComponentIds = $_POST['components'] ?? [];

        if (empty($selectedComponentIds)) {
            echo json_encode(['success' => false, 'message' => 'No components selected for rating.']);
            http_response_code(400);
            exit();
        }

        $selectedProducts = [];
        $totalPrice = 0;

        foreach ($selectedComponentIds as $id) {
            $product = $this->productModel->getProductById($id);
            if ($product) {
                $selectedProducts[] = $product;
                $totalPrice += $product['price'];
            }
        }

        if (empty($selectedProducts)) {
            echo json_encode(['success' => false, 'message' => 'Selected components could not be found.']);
            http_response_code(400);
            exit();
        }

        // --- Build Rating Logic (Simplified for now) ---
        $ratingScore = 0;
        $ratingComments = [];
        $hasCPU = false;
        $hasGPU = false;
        $hasMotherboard = false;
        $hasRAM = false;
        $hasPSU = false;
        $totalPowerConsumptionEstimate = 0;

        $cpuTier = 0;
        $gpuTier = 0;

        // Process each selected product
        foreach ($selectedProducts as $product) {
            switch ($product['category']) {
            case 'CPU':
                $hasCPU = true;
                if (str_contains($product['name'], 'i9') || str_contains($product['name'], 'Ryzen 9')) {
                    $cpuTier = 3;
                    $ratingComments[] = "High-end CPU selected: {$product['name']}.";
                } elseif (str_contains($product['name'], 'i7') || str_contains($product['name'], 'Ryzen 7') || str_contains($product['name'], 'i5') || str_contains($product['name'], 'Ryzen 5')) {
                    $cpuTier = 2;
                    $ratingComments[] = "Mid-range CPU selected: {$product['name']}.";
                } else {
                    $cpuTier = 1;
                    $ratingComments[] = "Entry-level CPU selected: {$product['name']}.";
                }
                $totalPowerConsumptionEstimate += 150;
                break;
            case 'GPU':
                $hasGPU = true;
                if (str_contains($product['name'], '4090') || str_contains($product['name'], '4080') || str_contains($product['name'], '3090') || str_contains($product['name'], '3080') || str_contains($product['name'], 'RX 7900')) {
                    $gpuTier = 3;
                    $ratingComments[] = "High-end GPU selected: {$product['name']}.";
                } elseif (str_contains($product['name'], '4070') || str_contains($product['name'], '3070') || str_contains($product['name'], '3060') || str_contains($product['name'], 'RX 6700')) {
                    $gpuTier = 2;
                    $ratingComments[] = "Mid-range GPU selected: {$product['name']}.";
                } else {
                    $gpuTier = 1;
                    $ratingComments[] = "Entry-level GPU selected: {$product['name']}.";
                }
                $totalPowerConsumptionEstimate += 300;
                break;
                case 'Motherboard':
                    $hasMotherboard = true;
                    break;
            case 'RAM':
                $hasRAM = true;
                if (str_contains($product['name'], '32GB') || str_contains($product['name'], '64GB')) {
                    $ratingScore += 5;
                    $ratingComments[] = "High RAM capacity selected: {$product['name']}.";
                }
                if (str_contains($product['name'], '6000MHz') || str_contains($product['name'], 'DDR5')) {
                    $ratingScore += 5;
                    $ratingComments[] = "High-speed or DDR5 RAM selected: {$product['name']}.";
                }
                break;
            case 'PSU':
                $hasPSU = true;
                $psuWattage = 0;
                if (preg_match('/(\d+)\s*W/', $product['name'], $matches)) {
                    $psuWattage = (int)$matches[1];
                }

                if ($psuWattage > 0) {
                    if ($psuWattage >= $totalPowerConsumptionEstimate * 1.2) {
                        $ratingScore += 10;
                        $ratingComments[] = "Power supply seems adequate for estimated power draw ({$psuWattage}W vs ~{$totalPowerConsumptionEstimate}W).";
                    } else {
                        $ratingComments[] = "Warning: Power supply (estimated {$psuWattage}W) might be insufficient for estimated power draw (~{$totalPowerConsumptionEstimate}W). Consider a higher wattage PSU.";
                        $ratingScore -= 10;
                    }
                    } else {
                        $ratingComments[] = "Warning: Could not determine wattage for selected PSU. Ensure the name contains a number followed by 'W' (e.g., '750W').";
                        $ratingScore -= 5;
                    }
                    break;
            case 'Motherboard':
                $hasMotherboard = true;
                $ratingComments[] = "Motherboard selected: {$product['name']}.";
                break;
            case 'Storage':
            case 'Case':
                    break;
            }
        }

        // Basic component presence check
        if ($hasCPU) $ratingScore += 10; else $ratingComments[] = "Missing CPU.";
        if ($hasGPU) $ratingScore += 10; else $ratingComments[] = "Missing GPU.";
        if ($hasMotherboard) $ratingScore += 10; else $ratingComments[] = "Missing Motherboard.";
        if ($hasRAM) $ratingScore += 10; else $ratingComments[] = "Missing RAM.";
        if ($hasPSU) $ratingScore += 10; else $ratingComments[] = "Missing Power Supply.";
        if ($cpuTier === 1 && $gpuTier === 3) {
            $ratingComments[] = "Potential Bottleneck: High-end GPU with a low-end CPU. Consider upgrading the CPU.";
            $ratingScore -= 15;
        } elseif ($cpuTier === 3 && $gpuTier === 1) {
            $ratingComments[] = "Potential Bottleneck: High-end CPU with a low-end GPU. Consider upgrading the GPU.";
            $ratingScore -= 15;
        } elseif ($cpuTier === 1 && $gpuTier === 2) {
             $ratingComments[] = "Potential Bottleneck: Mid-range GPU with a low-end CPU. Consider a better CPU.";
             $ratingScore -= 5;
        }

        // Ensure rating is within 0-100 range
        $ratingScore = max(0, min(100, $ratingScore));
        $qualitativeRating = "Your build looks good!";
        if ($ratingScore < 30) {
            $qualitativeRating = "This build has significant issues. Please review missing or incompatible components.";
        } elseif ($ratingScore < 60) {
            $qualitativeRating = "This is a decent start, but there are areas for improvement.";
        } elseif ($ratingScore < 80) {
            $qualitativeRating = "A solid build, capable of good performance!";
        } elseif ($ratingScore >= 90) {
            $qualitativeRating = "Excellent build! Well-balanced and powerful.";
        }

        $response = [
            'success' => true,
            'rating' => $ratingScore,
            'qualitative_rating' => $qualitativeRating,
            'comments' => $ratingComments,
            'total_price' => $totalPrice,
            'selected_products' => $selectedProducts
        ];

        echo json_encode($response);
        exit();
    }
}
