<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CouponExcelHandle
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $colspan = 3;
        $i = 1;
        $table = chr(239) . chr(187) . chr(191);
        $table .= '<table border="1">
        <thead>
        <tr style="text-align: center;font-size:16px;">
        <th colspan="' . $colspan . '" style="background-color:#eee;">' . 'coupon' . '
        </th></tr>
        <tr style="font-size:16px;text-align: center;" >
            <th >#</th>
            <th > coupon </th>
        </tr>
        </thead>
        <tbody>';

        if (count($this->data) > 0) {
            foreach ($this->data as $item) {
                $row = "<tr style='font-size:16px;text-align: center;'>" .
                    "<td >" . $i . "</td>" .
                    "<td >" . @$item . "</td>";
                $row .= "</tr>";
                ++$i;
                $table .= $row;
            }
        } else {
            $table .= '<tr style="text-align: center;font-size:16px;"><th colspan="' . $colspan . '" style="background-color:#eee;">' . __('dashboard.no_data') . '</th></tr>';
        }

        $table = $table . '</tbody></table>';

        $filename = 'coupons_' . date('d_m_Y'). '_' . uniqid() . '.xls';
        Storage::disk('local')->put("exports/{$filename}", $table);

        $downloadPath = url('couponsDownload/'.$filename);

        sendEmail(__('your_coupons_files') , __('click_here_to_download_the_file') . $downloadPath , getSeting('coupon_email'));

    }
}
