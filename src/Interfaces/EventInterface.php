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
}
