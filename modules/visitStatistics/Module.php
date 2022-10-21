<?php

namespace Modules\visitStatistics;

use Modules\visitStatistics\Models\RouteStatistics;

class Module
{
    public function set_layout_data()
    {
        new RouteStatistics();
    }

    public function admin_panel_index()
    {
        return [
            [
                'view' => 'visitStatistics::chart.month',
                'index' => 3
            ],
            [
                'view' => 'visitStatistics::chart.week',
                'index' => 4
            ],
        ];
    }

    public function registerComponent()
    {
        $routeName = getRouteName();
        if ($routeName == 'admin_index') {
            return veu_component_detail('visitStatistics');
        }
    }

}
