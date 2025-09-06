    /**
     * Calculate estimated days for custom order
     */
    public function calculateEstimation(Request $request)
    {
        $totalQuantity = $request->input('total_quantity', 0);
        $estimatedDays = CustomOrder::calculateEstimatedDays($totalQuantity);
        
        $orderDate = now();
        $completionDate = $orderDate->copy()->addDays($estimatedDays);
        
        return response()->json([
            'success' => true,
            'estimated_days' => $estimatedDays,
            'order_date' => $orderDate->format('d M Y'),
            'completion_date' => $completionDate->format('d M Y'),
            'working_days_info' => $this->getWorkingDaysInfo($estimatedDays)
        ]);
    }

    /**
     * Get working days information
     */
    private function getWorkingDaysInfo($estimatedDays)
    {
        if ($estimatedDays <= 3) {
            return "Pesanan cepat - siap dalam 3 hari kerja";
        } elseif ($estimatedDays <= 5) {
            return "Pesanan standar - siap dalam 5 hari kerja";
        } elseif ($estimatedDays <= 7) {
            return "Pesanan sedang - membutuhkan 1 minggu";
        } elseif ($estimatedDays <= 10) {
            return "Pesanan besar - membutuhkan 10 hari kerja";
        } else {
            return "Pesanan jumbo - membutuhkan 2 minggu";
        }
    }
