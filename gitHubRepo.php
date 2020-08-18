<?php

/**
 * Class gitHubRepo - api for getting data from the gitbug repositories repo and functions for dealing with the data we want to  save and get in a database
 */
class gitHubRepo {

    /**
     * @var mixed  $data - the data object returned from github
     */
    private $data;

    /**
     * @var string  - the url to connect to. Note we are sorting desc and by stars
     */
    private $url = 'https://api.github.com/search/repositories?q=language:php&sort=stars&order=desc';

    /**
     * gitHubRepo constructor. - connect using curl to githubrepo
     */
    public function __construct() {
         // set the curl options...
        $opts = array(CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_FOLLOWLOCATION => TRUE,
            CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT'],
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_SSL_VERIFYHOST =>  FALSE
        );

    // execute the curl call and get the data..
        $ch = curl_init($this->url);
        curl_setopt_array($ch,  $opts);
        $data = curl_exec($ch);
        curl_close($ch);

        if($data ) {
            $data = json_decode($data);
            if(isset($data->items)) {
                $this->data = $data;
                //echo "items: "  . var_export($this->data, true);
                return true;
            }
        }

        return false;
    }

    public  function getReposData() {
        if(isset($this->data->items)) {
            return  true;
        }

        return false;
    }

    /**
     * saveData : saev the data to a database
     * @param $dbh -
     */
    public function saveData($dbh) {
        // always delete any previous data
        $sth = $dbh->prepare("TRUNCATE  TABLE repos");
        $sth->execute();

        foreach($this->data->items  as $item) {
            //echo "working on item $item->name";
            $sql = "INSERT INTO repos (`repo_id`, `name`, `url`, `desc`, `stars`, `created`, `last_push`, `rawdata`) VALUES (?,?,?,?,?,?,?,?)";
            $stmt= $dbh->prepare($sql);
            $stmt->execute([$item->id,
                $item->name,
                $item->html_url,
                $item->description,
                $item->stargazers_count,
                $item->created_at,
                $item->pushed_at,
                serialize($item)]
            );
           // echo ": " .  $stmt->rowCount() . ",";

        }

        return;
    }

    /**
     * getData - retrieve all the rows from table repos
     * @param $dbh-  db handle
     *
     * @return mixed
     */
    public function getData($dbh) {
        $sth = $dbh->prepare("SELECT `repo_id` as `id`, `name`, `url` as `html_url`, `created` as `created_at`, `last_push` as `pushed_at`, `desc` as `description`, `stars` as `stargazers_count`  FROM repos");
        $sth->execute();

        /* Fetch all of the remaining rows in the result set */
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * getItem - for the detail view, retrive 1 item by repo_id value
     * @param $dbh - db handle
     * @param $repo_id - repo_id we ant to retrieve info for
     *
     * @return mixed
     */
    public static function getItem($dbh, $repo_id) {
        $sth = $dbh->prepare("SELECT *  FROM repos where repo_id=?");
        $sth->execute([$repo_id]);
        return $sth->fetch(PDO::FETCH_ASSOC);
    }
}

