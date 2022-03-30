<?php
namespace App\Http\ViewComposers;

use App\Navigation;
use App\Contentblock;
use App\Course;
use App\Testimonial;
use App\Banner;
use App\ImageCategory;
use App\Blog;
use App\BlogCategory;
use DB;
class NavComposer
{
    public function compose($view)
    {
        $footertab_content  = Contentblock::select('title','content')
                                             ->where('aliases','Like','footertab%')
                                             ->where('status','Active')
                                             ->orderBy('position')->get();
        $header_menu = Navigation::where('position_block','header')->orderBy('parent_id')->orderBy('position_order')->get();
        $header_nav = array();
        if(count($header_menu)>0){ 
            foreach($header_menu as $menu)
            {
                if($menu->parent_id==0){
                    $header_nav[$menu->id] = ['title'=>$menu->title,
                                            'link_url'=>$menu->link_url,
                                            'target'=>$menu->target,
                                            'class_name'=>$menu->class_name,
                                            'child'=>array()];    
                }else{
                    $header_nav[$menu->parent_id]['child'][] = ['title'=>$menu->title,
                                            'link_url'=>$menu->link_url,
                                            'target'=>$menu->target,
                                            'class_name'=>$menu->class_name];
                }
                    
            } 
        }  
        
        $footer_menu = Navigation::where('position_block','footer_menu')->orderBy('parent_id')->orderBy('position_order')->get();
        $footer_nav = array();
        if(count($footer_menu)>0){ 
            foreach($footer_menu as $menu)
            {
                if($menu->parent_id==0){
                    $footer_nav[$menu->id] = ['title'=>$menu->title,
                                            'link_url'=>$menu->link_url,
                                            'target'=>$menu->target,
                                            'class_name'=>$menu->class_name,
                                            'child'=>array()];    
                }else{
                    $footer_nav[$menu->parent_id]['child'][] = ['title'=>$menu->title,
                                            'link_url'=>$menu->link_url,
                                            'target'=>$menu->target,
                                            'class_name'=>$menu->class_name];
                }
                    
            } 
        }  
        $view->with('header_nav', $header_nav)
                ->with('footer_nav', $footer_nav)
                ->with('footertab_content',$footertab_content); 
    }
} 