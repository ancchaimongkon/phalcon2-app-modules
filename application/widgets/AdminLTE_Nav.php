<?php

namespace Multiple\Widgets;

use \HTML;
use Multiple\Components\CComponent;

class AdminLTE_Nav extends CComponent {
    
    public function getNav($navs = array()){
        
        $mainClass = array('class'=>'treeview');
        $subClass = array('class'=>'treeview-menu');

        $mainIcon = array('class'=>'icon icon-dashboard');
        $listIcon = array('class'=>'icon icon-circle-o');
        $subIcon = array('class'=>'icon icon-angle-left pull-right');

        $_navs = !empty($navs) ? $navs : $this->nav();
        
        $navHTML = null;
        
        foreach ($_navs as $key => $rows) {

            if (!empty($rows['header'])) {
                $navHTML .= HTML::tag('li',$rows['header'],array('class'=>'header'));
            }

            foreach ($rows['items'] as $key => $nav){
                if(!empty($nav['items'])){
                    $oneLabel = HTML::tag('a',HTML::tag('i','&nbsp;',$mainIcon).''.HTML::tag('span',$nav['label']).HTML::tag('i','&nbsp;',$subIcon),array('href'=>'#'));
                    $oneText = "";
                    foreach ($nav['items'] as $one){
                        if(!empty($one['items'])){
                            $twoLabel = HTML::tag('a',HTML::tag('i','&nbsp;',$mainIcon).HTML::tag('span',$one['label']).HTML::tag('i','&nbsp;',$subIcon),array('href'=>'#'));
                            $twoText = "";
                            foreach ($one['items'] as $two){
                                if(!empty($two['items'])){
                                    $threeLabel = HTML::tag('a',HTML::tag('i','&nbsp;',$mainIcon).HTML::tag('span',$two['label']).HTML::tag('i','&nbsp;',$subIcon),array('href'=>'#'));
                                    $threeText = "";
                                    foreach ($two['items'] as $three){
                                        $threeText .= HTML::tag('li',HTML::tag('a',HTML::tag('i','&nbsp;',$listIcon).HTML::tag('span',$three['label']),array('href'=>$this->url->get($three['url'])))); 
                                    }
                                    $twoText .= HTML::tag('li',$threeLabel.HTML::tag('ul',$threeText,$subClass),$mainClass);
                                } else {
                                    $twoText .= HTML::tag('li',HTML::tag('a',HTML::tag('i','&nbsp;',$listIcon).HTML::tag('span',$two['label']),array('href'=>$this->url->get($two['url'])))); 
                                }
                            }
                            $oneText .= HTML::tag('li',$twoLabel.HTML::tag('ul',$twoText,$subClass),$mainClass);
                        } else {
                            $oneText .= HTML::tag('li',HTML::tag('a',HTML::tag('i','&nbsp;',$listIcon).HTML::tag('span',$one['label']),array('href'=>$this->url->get($one['url']))));
                        }
                    }
                    $navHTML .= HTML::tag('li',$oneLabel.HTML::tag('ul',$oneText,$subClass),$mainClass);
                } else {
                    $navHTML .= HTML::tag('li',HTML::tag('a',HTML::tag('i','&nbsp;',$listIcon).HTML::tag('span',$nav['label']),array('href'=>$this->url->get($nav['url']))));
                }
            }
        }
        
        return !empty($navHTML) ? $navHTML : null;
        
    }
    
    public function nav(){
        return array(
            array(
                'header' => 'MAIN NAVIGATION',
                'items' => array(
                    array(
                        'label' => 'Dashboard',
                        'items' => array(
                            array('label' => 'Dashboard v1', 'url' => 'v1'),
                            array('label' => 'Dashboard v2', 'url' => 'v2'),
                        )
                    ),
                    array(
                        'label' => 'Multilevel',
                        'items' => array(
                            array('label' => 'Level One', 'url' => 'v1'),
                            array(
                                'label' => 'Level Two', 
                                'items' => array(
                                    array('label' => 'Level Two', 'url' => 'v1'),
                                    array(
                                        'label' => 'Level Two',
                                        'items' => array(
                                            array('label' => 'Level Three', 'url' => 'v1'),
                                            array('label' => 'Level Three', 'url' => 'v2'),
                                        )
                                    ),
                                )
                            ),
                            array('label' => 'Level One', 'url' => 'v1'),
                        )
                    ),
                ),
            ),
            array(
                'header' => 'Example',
                'items' => array(
                    array(
                        'label' => 'Example',
                        'items' => array(
                            array('label' => 'Table', 'url' => '/dashboard/ex/table'),
                            array('label' => 'Form', 'url' => '/dashboard/ex/form'),
                            array('label' => 'Tab', 'url' => '/dashboard/ex/tab'),
                            array('label' => 'Nav', 'url' => '/dashboard/ex/nav'),
                            array('label' => 'Code', 'url' => '/dashboard/ex/code'),
                            array('label' => 'Timeline', 'url' => '/dashboard/ex/timeline'),
                        )
                    ),
                ),
            ),
            
        );
        
    }
    
    public function navExample(){
        return array(
            array(
                'header' => 'MAIN NAVIGATION',
                'items' => array(
                    array(
                        'label' => 'Dashboard',
                        'items' => array(
                            array('label' => 'Dashboard v1', 'url' => 'v1'),
                            array('label' => 'Dashboard v2', 'url' => 'v2'),
                        )
                    ),
                    array(
                        'label' => 'Multilevel',
                        'items' => array(
                            array('label' => 'Level One', 'url' => 'v1'),
                            array(
                                'label' => 'Level Two', 
                                'items' => array(
                                    array('label' => 'Level Two', 'url' => 'v1'),
                                    array(
                                        'label' => 'Level Two',
                                        'items' => array(
                                            array('label' => 'Level Three', 'url' => 'v1'),
                                            array('label' => 'Level Three', 'url' => 'v2'),
                                        )
                                    ),
                                )
                            ),
                            array('label' => 'Level One', 'url' => 'v1'),
                        )
                    ),
                ),
            ),
            array(
                'header' => 'Example',
                'items' => array(
                    array(
                        'label' => 'Example',
                        'items' => array(
                            array('label' => 'Table', 'url' => 'example/table'),
                            array('label' => 'Form', 'url' => 'example/form'),
                            array('label' => 'Tab', 'url' => 'example/tab'),
                            array('label' => 'Nav', 'url' => 'example/nav'),
                            array('label' => 'Code', 'url' => 'example/code'),
                            array('label' => 'Timeline', 'url' => 'example/timeline'),
                        )
                    ),
                ),
            ),
            
        );
        
    }
    
}