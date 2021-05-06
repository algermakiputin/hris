<?php

namespace App\Http\Controllers;

use Phpml\Dataset\CsvDataset;
use Phpml\Dataset\ArrayDataset;

use Illuminate\Http\Request;
 
use Phpml\Association\Apriori;

class ClassificationController extends Controller
{
    public function index() {

    		$classifier = new \Phpml\Classification\NaiveBayes;

    		//Testing Data
		$samples = [
			['assistant prof', 2],
			['professor', 5],    
		];

		$class = [
			'no',
			'yes',  
			];

		$associator = new Apriori($support = 0.5, $confidence = 0.5);
		$associator->train($samples, $class);
		dd($associator->apriori());
		//Unseen Data
		$jeff = ['professor', 4];

		//LEARN FROM DATA
		$classifier->train($this->set($samples), $class);	

 		//PREDICT JEFF
		// dd($classifier->predict($jeff));

		//GET COMMON VARIABLES OF SAMPLE DATA
 		 dd($this->getProbability($classifier));
		

 

		// return view('Classification.index');
    }


    	public function getProbability($classifier) {

    		$test = ((array)$classifier);
 		$s = [];
 		
 		foreach($test as $t) {

 			$s[] = $t;

 		}

 		return $s[2];
    	}

    	public function set($data) { 

    		$newData = [];

    		for ($i = 0; $i < count($data); $i++) {

    			if ($data[$i][1] < 3) {
    				$data[$i][1] = '1 to 3 years';
    			} else {
    				$data[$i][1] = '4 to 6 years';
    			}


    			$newData[] = $data[$i];
    		}

    		return $newData;


    	}
}
