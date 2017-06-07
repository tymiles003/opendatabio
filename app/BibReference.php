<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use RenanBr\BibTexParser\Listener as Listener;
use RenanBr\BibTexParser\Parser as Parser;
use RenanBr\BibTexParser\ParseException as ParseException;
use App\Structures_BibTex;


use Illuminate\Support\Facades\Log;

class BibReference extends Model
{
	// "cached" entries, so we don't need to parse the bibtex for every call
	protected $entries = null;
	protected $appends = ['author', 'title', 'year', 'bibkey'];
	protected $fillable = ['bibtex'];

	public function validBibtex($string) {
		$listener = new Listener;
		$parser = new Parser;
		$parser->addListener($listener);
		try {
			$parser->parseString($string);
		} catch (ParseException $e) {
			return false;
		}
		return true;
	}

	public static function createFromFile($contents, $standardize) {
		$listener = new Listener;
		$parser = new Parser;
		$parser->addListener($listener);
		$parser->parseString($contents);
		$newentries = $listener->export();
		foreach($newentries as $entry) {
			if ($standardize) {
				$bibtex = new Structures_BibTex;
				$bibtex->parse_string($entry['_original']);
				$fword = trim(strtolower(strtok($bibtex->data[0]['title'], ' ')));
				while (in_array($fword, ['a', 'an', 'the', 'on', 'of', 'in', 'as', 'at', 'for', 'from', 'where', 'i', 'are', 'is', 'it', 'that', 'this']))
					$fword = strtok(' ');
				$slug = strtolower(
					$bibtex->data[0]['author'][0]['von'] .
					$bibtex->data[0]['author'][0]['last'] .
					$bibtex->data[0]['year'] .
					$fword
				);
				$bibtex->data[0]['cite'] = $slug;
			BibReference::create(['bibtex' => $bibtex->bibTex()]);
			} else {

				BibReference::create(['bibtex' => $entry['_original']]);
			}
		}
	}


	private function parseBibtex() {
		$listener = new Listener;
		$parser = new Parser;
		$parser->addListener($listener);
		try {
			$parser->parseString($this->bibtex);
		} catch (ParseException $e) {
			Log::error("Error handling bibtex:". $e->getMessage());
			$this->entries[0] = ['author' => null, 'title' => null, 'year' => null, 'citation-key' => 'Invalid'];
			return;
		}
		$this->entries = $listener->export();
	}

	public function getAuthorAttribute() {
		if (is_null($this->entries)) 
			$this->parseBibtex();
		if(count($this->entries) > 0) {
			return $this->entries[0]['author'];
		} else {
			return '';
		}
	}
	public function getTitleAttribute() {
		if (is_null($this->entries)) 
			$this->parseBibtex();
		if(count($this->entries) > 0) {
			return $this->entries[0]['title'];
		} else {
			return '';
		}
	}
	public function getYearAttribute() {
		if (is_null($this->entries)) 
			$this->parseBibtex();
		if(count($this->entries) > 0) {
			return $this->entries[0]['year'];
		} else {
			return '';
		}
	}
	public function getBibkeyAttribute() {
		if (is_null($this->entries)) 
			$this->parseBibtex();
		if(count($this->entries) > 0) {
			return $this->entries[0]['citation-key'];
		} else {
			return '';
		}
	}

}