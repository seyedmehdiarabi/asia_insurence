<?php


namespace Modules\panelTheme;


class Module
{
    public function registerComponent(){
        return veu_component_detail('panelTheme');
    }
}
