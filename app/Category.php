<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;
use Config;

class Category extends Model
{
    protected $fillable = ['title', 'pid' ];

    private $nodesMap;


    /**
     * Build categories connections
     *
     * @return object
     */
    public function buildCategoriesConnections()
    {
        $this->nodesMap = [];
        $rows = $this->select("title", "pid", "id")->orderBy("pid")->orderBy("order_position")->get()->toArray();

        $rootNode = new \App\Node([ 'id' => 0,  'pid' => null  ,'title' => 'Root', 'depth' => 0 ]);
        $this->addNodeToArray($rootNode);
        $node = & $rootNode;

        foreach ($rows as $row) {
            if ($node->data->id != $row['pid']) {
                $node = & $this->nodesMap[ $row['pid'] ];
            }

            $newNode = new \App\Node($row);
            $node->addChild($newNode);
            $this->addNodeToArray($newNode);
        }

        return $rootNode;
    }

    
    /**
     * Add node pointer to array
     *
     * @var object $node
     * @return void
     */
    public function addNodeToArray(& $node)
    {
        $this->nodesMap[ $node->data->id ] = $node;
    }

    /**
     * Get categories for iterative display
     *
     * @return array
     */
    public function getIterative()
    {
        $categoriesArray = array();
        $rows = $this->select("title", "pid", "id")->orderBy("pid")->orderBy("order_position")->get()->toArray();

        foreach ($rows as $row) {
            if ($row['pid'] == 0) {
                $row['depth'] = 0;
                $categoriesArray[] = $row;
            } else {
                list($key, $depth) = $this->getInsertDataByPid($row['pid'], $categoriesArray);
                $parentItem = $categoriesArray[$key];
                $row['depth'] = $depth + 1;

                array_insert($categoriesArray, $key+1, array($row));
            }
        }

        return $categoriesArray;
    }

    /**
     * Get insert data  by pid
     *
     * @var int pid
     * @var array rows
     * @return array
     */
    public function getInsertDataByPid($pid, & $rows)
    {
        $key = false;
        $parentPid = false;
        $parentLevel = false;

        foreach ($rows as $index => $row) {
            // found parent
            if ($row['id'] == $pid) {
                $key = $index;
                $parentPid = $row['pid'];
                $parentLevel = $row['depth'];
            // found row with the same pid as parent row
            } elseif ($parentPid === $row['pid']) {
                $key = $index-1;
                break;
            }
        }

        return array( $key, $parentLevel );
    }

    /**
     * Get categories for iterative display with que
     *
     * @return array
     */
    public function getIterativeQue()
    {
        $rootNode = $this->buildCategoriesConnections();

        $categoriesArray = [];
        $node = & $rootNode;
        $que = [$node];

        while (count($que)) {

            // pop the element of the end of array
            $node = array_pop($que);

            if ($node->data->depth != 0) {
                $categoriesArray[] = (array)$node->data;
            }

            foreach (array_reverse($node->children) as $child) {
                // append at the end
                array_push($que, $child);
            }
        }

        return $categoriesArray;
    }
}




function array_insert(&$array, $position, $insert)
{
    if (is_int($position)) {
        array_splice($array, $position, 0, $insert);
    } else {
        $pos = array_search($position, array_keys($array));
        $array = array_merge(
            array_slice($array, 0, $pos),
            $insert,
            array_slice($array, $pos)
        );
    }
}
