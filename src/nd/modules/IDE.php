<?php
namespace nd\modules;

use std, gui, framework, nd;


class IDE extends AbstractModule
{
    public static function ico($name)
    {
        return self::image("res://.data/img/" . $name);
    }
    
    public static function image($path)
    {
        return new UXImageView(new UXImage($path));
    }
    
    public static function get()
    {
        return $GLOBALS['ND'];
    }
    
    public static function upgradeListView(UXListView $listView)
    {
        $listView->setCellFactory(function(UXListCell $cell, $item) {
            if ($item) {              
                $titleName = new UXLabel($item[0]);
                $titleName->style = '-fx-font-weight: bold;'; 
             
                $titleDescription = new UXLabel($item[1]);
                $titleDescription->style = '-fx-text-fill: gray;';
             
                $title  = new UXVBox([$titleName, $titleDescription]);
                $title->spacing = 0;
               
                $line = new UXHBox([$item[2], $title]);
                $line->spacing = 7;
                $line->padding = 5;
                $line->on('click', function (UXMouseEvent $e) use ($item) {
                    if ($e->clickCount < 2) return;
                    $callback = $item[3];
                    if (!is_callable($callback)) return;
                    $callback();
                });
                $cell->text = null;
                $cell->graphic = $line;
            }
        });
    }
}