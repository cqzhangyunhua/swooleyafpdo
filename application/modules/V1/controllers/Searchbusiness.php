<?php

use \Transformers\Es\Elasticsearch;

/**
 * Search
 * @author: 
 */
class SearchbusinessController extends Yaf_Controller_Abstract
{

    /**
     * read
     * @author: zhang yun hua
     */
    public function indexAction()
    {

        $config = Yaf_Registry::get("config");
        $esconfig = $config['elasticsearch'];
        $request = Yaf_Registry::get("swoole_req");
        $k = trim($request->get["k"]);
        if ($k != '') {
            $a = new Elasticsearch();
            $str2 = '
            {
            "query": {
                "match_phrase": {
                    "name": {
                        "query": "' . $k . '",
                        "slop": 1
                    }
                }
            }
            }
           ';

            $rs_temp = $a->search("http://" . $esconfig . "/user_business/_search", $str2);
            echo json_encode($rs_temp);
            // $this->resultJson(200, "ok", $rs_temp);
        } else {
            echo json_encode([]);
            ///$this->resultJson(400, "error", []);
        }
    }

    /**
     * create
     * @author: xx
     */
    public function createAction()
    { }

    /**
     * update
     * @author: xx
     */
    public function updateAction()
    { }

    /**
     * delete
     * @author: xx
     */
    public function deleteAction()
    { }
}
