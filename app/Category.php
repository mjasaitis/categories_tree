<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;
use Config;

class Category extends Model
{
    protected $fillable = ['title', 'pid' ];


    /**
     * Get categories for recursive display
     *
     * @return array
     */
    public function getRecursive(){

        $categoriesArray=array();
        $rows = $this->select("title", "pid", "id" )->orderBy("pid")->orderBy("order_position")->get()->toArray();
        foreach( $rows as $row ){

            $pid = $row["pid"];

            if( !isset( $categoriesArray[ $pid ] ) )
                $categoriesArray[ $pid ] = array();

            $categoriesArray[ $pid ][] = $row;

        }

        return $categoriesArray;

    }

    /**
     * Get categories for iterative display
     *
     * @return array
     */
    public function getIterative(){

        $categoriesArray = array();
        $rows = $this->select("title", "pid", "id" )->orderBy("pid")->orderBy("order_position")->get()->toArray();

        foreach( $rows as $row ){

            if( $row['pid'] == 0 ) {
                $row['level'] = 0;
                $categoriesArray[] = $row;
            }
            else {
                $key = $this->getKeyByPid( $row['pid'], $categoriesArray );

                $parentItem = $categoriesArray[$key];
                $row['level'] = $parentItem['level'] + 1; 

                array_insert($categoriesArray, $key+1, array($row) ) ;

                //$categoriesArray =  array_slice($categoriesArray, 0, $key, true) +
                //        array( $row ) +
                //        array_slice($categoriesArray, $key, count($categoriesArray)-$key, true);

            }

        }

        return $categoriesArray; 


    }


    /**
     * Get array key by pid
     *
     * @var int pid
     * @var array rows
     * @return integer
     */
    public function getKeyByPid($pid, & $rows){

        foreach( $rows as $key => $row ){
            if( $row['id'] == $pid ){
                return $key;
            }
        }

        return false;

    }





}

function array_insert(&$array, $position, $insert)
{
    if (is_int($position)) {
        array_splice($array, $position, 0, $insert);
    } else {
        $pos   = array_search($position, array_keys($array));
        $array = array_merge(
            array_slice($array, 0, $pos),
            $insert,
            array_slice($array, $pos)
        );
    }
}
