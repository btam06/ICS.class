<?php
namespace Itzamna;

/**
 * @copyright  Copyright (c) 2018 Brian Tam
 * @author     Brian Tam [bt] <btam06@gmail.com>
 * @license    MIT
 */
interface EventInterface
{
    /**
     *
     */
    public function getOrganizer();

     /**
      * [getUid description]
      * @return [type] [description]
      */
    public function getUid();

    /**
     * [getTimezone description]
     * @return [type] [description]
     */
    public function getTimezone();

    /**
     * [getStartDate description]
     * @return [type] [description]
     */
    public function getStartDate();

    /**
     * [getEndDate description]
     * @return [type] [description]
     */
    public function getEndDate();

    /**
     * [getSummary description]
     * @return [type] [description]
     */
    public function getSummary();

    /**
     * [getLocation description]
     * @return [type] [description]
     */
    public function getLocation();

    /**
     * [getDescription description]
     * @return [type] [description]
     */
    public function getDescription();

    /**
     * [getCategories description]
     * @return [type] [description]
     */
    public function getCategories();


    /**
     * [setOrganizer description]
     * @param [type] $organizer [description]
     */
    public function setOrganizer($organizer);

    /**
     * [setUid description]
     * @param [type] $uid [description]
     */
    public function setUid($uid);

    /**
     * [setTimezone description]
     * @param [type] $timezone [description]
     */
    public function setTimezone($timezone);

    /**
     * [setStartDate description]
     * @param [type] $start_date [description]
     */
    public function setStartDate($start_date);

    /**
     * [setEndDate description]
     * @param [type] $end_date [description]
     */
    public function setEndDate($end_date);

    /**
     * [setSummary description]
     * @param [type] $summary [description]
     */
    public function setSummary($summary);

    /**
     * [setLocation description]
     * @param [type] $location [description]
     */
    public function setLocation($location);

    /**
     * [setDescription description]
     * @param [type] $description [description]
     */
    public function setDescription($description);

    /**
     * [setCategories description]
     * @param [type] $categories [description]
     */
    public function setCategories($categories);
}
