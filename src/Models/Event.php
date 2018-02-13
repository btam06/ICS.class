<?php
namespace Itzamna;

use Carbon\Carbon;
use \Exception;
use \InvalidArgumentException;
/**
 * @copyright  Copyright (c) 2018 Brian Tam
 * @author     Brian Tam [bt] <btam06@gmail.com>
 * @license    MIT
 */
class Event implements EventInterface
{
        /**
         * [protected description]
         * @var [type]
         */
        protected $organizer;

        /**
         * [protected description]
         * @var [type]
         */
        protected $uid;

        /**
         * [protected description]
         * @var [type]
         */
        protected $timezone;

        /**
         * [protected description]
         * @var [type]
         */
        protected $startDate;

        /**
         * [protected description]
         * @var [type]
         */
        protected $endDate;

        /**
         * [protected description]
         * @var [type]
         */
        protected $summary;

        /**
         * [protected description]
         * @var [type]
         */
        protected $location;

        /**
         * [protected description]
         * @var [type]
         */
        protected $description;

        /**
         * [protected description]
         * @var [type]
         */
        protected $categories;

        /**
    	 * [getOrganizer description]
    	 * @return [type] [description]
    	 */
    	public function getOrganizer() {
    		return $this->organizer;
    	}

    	/**
    	 * [getUid description]
    	 * @return [type] [description]
    	 */
    	public function getUid() {
    		return $this->uid;
    	}

    	/**
    	 * [getTimezone description]
    	 * @return [type] [description]
    	 */
    	public function getTimezone() {
    		return $this->timezone;
    	}

    	/**
    	 * [getStartDate description]
    	 * @return [type] [description]
    	 */
    	public function getStartDate() {
    		return $this->startDate;
    	}

    	/**
    	 * [getEndDate description]
    	 * @return [type] [description]
    	 */
    	public function getEndDate() {
    		return $this->endDate;
    	}

    	/**
    	 * [getSummary description]
    	 * @return [type] [description]
    	 */
    	public function getSummary() {
    		return $this->summary;
    	}

    	/**
    	 * [getLocation description]
    	 * @return [type] [description]
    	 */
    	public function getLocation() {
    		return $this->location;
    	}

    	/**
    	 * [getDescription description]
    	 * @return [type] [description]
    	 */
    	public function getDescription() {
    		return $this->description;
    	}

    	/**
    	 * [getCategories description]
    	 * @return [type] [description]
    	 */
    	public function getCategories() {
    		return $this->categories;
    	}

    	/**
    	 * [setOrganizer description]
    	 * @param [type] $organizer [description]
    	 */
    	public function setOrganizer($organizer) {
    		$this->organizer = strip_tags($organizer);
    		return $this;
    	}

    	/**
    	 * [setUid description]
    	 * @param [type] $uid [description]
    	 */
    	public function setUid($uid) {
    		$this->uid = strip_tags($uid);
    		return $this;
    	}

    	/**
    	 * [setTimezone description]
    	 * @param [type] $timezone [description]
    	 */
    	public function setTimezone($timezone) {
            try {
                $timestamp = new Carbon();
                $timestamp->setTimezone($timezone);
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage());
            }
    		$this->timezone = $timezone;
    		return $this;
    	}

    	/**
    	 * [setStartDate description]
    	 * @param [type] $start_date [description]
    	 */
    	public function setStartDate($start_date) {
    		$this->startDate = $start_date;
    		return $this;
    	}

    	/**
    	 * [setEndDate description]
    	 * @param [type] $end_date [description]
    	 */
    	public function setEndDate($end_date) {
    		$this->endDate = $end_date;
    		return $this;
    	}

    	/**
    	 * [setSummary description]
    	 * @param [type] $summary [description]
    	 */
    	public function setSummary($summary) {
    		$this->summary = $summary;
    		return $this;
    	}

    	/**
    	 * [setLocation description]
    	 * @param [type] $location [description]
    	 */
    	public function setLocation($location) {
    		$this->location = $location;
    		return $this;
    	}

    	/**
    	 * [setDescription description]
    	 * @param [type] $description [description]
    	 */
    	public function setDescription($description) {
    		$this->description = $description;
    		return $this;
    	}

    	/**
    	 * [setCategories description]
    	 * @param [type] $categories [description]
    	 */
    	public function setCategories($categories) {
    		$this->categories = strip_tags($categories);
    		return $this;
    	}
}
