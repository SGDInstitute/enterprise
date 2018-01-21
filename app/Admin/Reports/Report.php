<?php

namespace App\Admin\Reports;

class Report
{
    public function generateHtml()
    {
        return view($this->view, ['data' => $this->query()])->render();
    }
}
