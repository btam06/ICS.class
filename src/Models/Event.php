<?php
namespace Itzamna;

use Carbon\Carbon;
use \Exception;
use \InvalidArgumentException;
/**
 * @copyright  Copyright (c) 2018 Avery Tam
 * @author     Avery Tam [bt] <btam06@gmail.com>
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
    	 * [getICSOrganizer description]
    	 * @return [type] [description]
    	 */
    	public function getICSOrganizer() {
    		return $this->organizer;
    	}

    	/**
    	 * [getICSUid description]
    	 * @return [type] [description]
    	 */
    	public function getICSUid() {
    		return $this->uid;
    	}

    	/**
    	 * [getICSTimezone description]
    	 * @return [type] [description]
    	 */
    	public function getICSTimezone() {
    		return $this->timezone;
    	}

    	/**
    	 * [getICSStartDate description]
    	 * @return [type] [description]
    	 */
    	public function getICSStartDate() {
    		return $this->startDate;
    	}

    	/**
    	 * [getICSEndDate description]
    	 * @return [type] [description]
    	 */
    	public function getICSEndDate() {
    		return $this->endDate;
    	}

    	/**
    	 * [getICSSummary description]
    	 * @return [type] [description]
    	 */
    	public function getICSSummary() {
    		return $this->summary;
    	}

    	/**
    	 * [getICSLocation description]
    	 * @return [type] [description]
    	 */
    	public function getICSLocation() {
    		return $this->location;
    	}

    	/**
    	 * [getICSDescription description]
    	 * @return [type] [description]
    	 */
    	public function getICSDescription() {
    		return $this->description;
    	}

    	/**
    	 * [getICSCategories description]
    	 * @return [type] [description]
    	 */
    	public function getICSCategories() {
    		return $this->categories;
    	}

    	/**
    	 * [setICSOrganizer description]
    	 * @param [type] $organizer [description]
    	 */
    	public function setICSOrganizer($organizer) {
    		$this->organizer = strip_tags($organizer);
    		return $this;
    	}

    	/**
    	 * [setICSUid description]
    	 * @param [type] $uid [description]
    	 */
    	public function setICSUid($uid) {
    		$this->uid = strip_tags($uid);
    		return $this;
    	}

    	/**
    	 * [setICSTimezone description]
    	 * @param [type] $timezone [description]
    	 */
    	public function setICSTimezone($timezone) {
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
    	 * [setICSStartDate description]
    	 * @param [type] $start_date [description]
    	 */
    	public function setICSStartDate($start_date) {
    		$this->startDate = $start_date;
    		return $this;
    	}

    	/**
    	 * [setICSEndDate description]
    	 * @param [type] $end_date [description]
    	 */
    	public function setICSEndDate($end_date) {
    		$this->endDate = $end_date;
    		return $this;
    	}

    	/**
    	 * [setICSSummary description]
    	 * @param [type] $summary [description]
    	 */
    	public function setICSSummary($summary) {
    		$this->summary = $summary;
    		return $this;
    	}

    	/**
    	 * [setICSLocation description]
    	 * @param [type] $location [description]
    	 */
    	public function setICSLocation($location) {
    		$this->location = $location;
    		return $this;
    	}

    	/**
    	 * [setICSDescription description]
    	 * @param [type] $description [description]
    	 */
    	public function setICSDescription($description) {
    		$this->description = $description;
    		return $this;
    	}

    	/**
    	 * [setICSCategories description]
    	 * @param [type] $categories [description]
    	 */
    	public function setICSCategories($categories) {
    		$this->categories = strip_tags($categories);
    		return $this;
    	}
}
