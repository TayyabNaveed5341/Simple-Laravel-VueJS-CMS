<?php
namespace App\Services;



class PageService{
    public function generateFullPath($page){
        /*  TODO:
            find more efficient solution to reach most senior page
        */
        $slugPath = $page->slug;
        $pParent = $page->parent;
        while(!is_null($pParent)){
            $slugPath = $pParent->slug.'/'.$slugPath;
            $pParent = $pParent->parent;
        }
        return $slugPath;
    }
}