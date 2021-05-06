<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Rubix\ML\Datasets\Labeled;
use Rubix\ML\Classifiers\ClassificationTree;
use Rubix\ML\Classifiers\NaiveBayes;

class RubixController extends Controller
{
    public function index() {


		$samples = [
		    [22, 4, 50.5], [35, 5, 24.7], [44, 4, 62.], [3, 2, 31.1]
		];

		$samples2 = [
		    [22, 4, 30.5]
		];
		$labels = ['married'];

		$dataset = new Labeled($samples, $labels);
		$estimator = new NaiveBayes(0.5, false);
		$dataset2 = new Labeled($samples2,$labels);
	 
	 
		$estimator = new ClassificationTree(100, 7, 4, 1e-4);

		// $dataset = $dataset->filterByColumn(0, function ($value) {
		// 	return $value = "test";
		// });

 
		$estimator->train($dataset);

		$prediction = $estimator->predict($dataset2);

		dd($prediction);

    }
}
