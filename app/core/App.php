<?php 

class App {
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];


    public function __construct()
    {
        $url = $this->parseUrl();
        // var_dump($url);
        //jika url nya tidak null maka proses controller baru
        if (isset($url)){
        //     //Jadikan aray ke-0 sbg controller
            if (file_exists('../app/controllers/'. $url[0] .'.php')){
                $this->controller = $url[0];
                unset($url[0]);
                
            }
        }

        //panggil controller baru
        require_once '../app/controllers/'. $this->controller .'.php';
        //Instansiasi kelas 
        $this->controller = new $this->controller;


        //Jadikan array ke-1 sebagai method
        if (isset($url[1])){
            if (method_exists($this->controller, $url[1])){
                //ganti method default dengan method yang diinputkan user
                $this->method = $url[1];
                unset($url[1]);
                    
            }
       }

        //Kelelo paramter nya
        if (!empty($url)){
           $this->params = array_values($url);
              
        }
            
    
       
        

        //Jalankan controler dan method serta kirim params jika ada
        call_user_func_array([$this->controller, $this->method], $this->params);

    }


    public function parseUrl(){
        if (isset($_GET['url'])){
            //Agar menghilangkan char / pada akhir url
            $url = rtrim($_GET['url'], '/');
            //Untuk mengamankan url dari char aneh
            $url = filter_var($url, FILTER_SANITIZE_URL);
            //jadikan url menjadi array
            $url = explode('/', $url);
            return $url;

        }
    }
}