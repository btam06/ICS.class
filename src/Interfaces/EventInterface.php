<?php
namespace Itzamna;

/**
 * @copyright  Copyright (c) 2018 Avery Tam
 * @author     Avery Tam [at] <btam06@gmail.com>
 * @license    MIT
 */
interface EventInterface
{
    /**
     *
     */
    public function getICSOrganizer();

     /**
      * [getICSUid description]
      * @return [type] [description]
      */
    public function getICSUid();

    /**
     * [getICSTimezone description]
     * @return [type] [description]
     */
    public function getICSTimezone();

    /**
     * [getICSStartDate description]
     * @return [type] [description]
     */
    public function getICSStartDate();

    /**
     * [getICSEndDate description]
     * @return [type] [description]
     */
    public function getICSEndDate();

    /**
     * [getICSSummary description]
     * @return [type] [description]
     */
    public function getICSSummary();

    /**
     * [getICSLocation description]
     * @return [type] [description]
     */
    public function getICSLocation();

    /**
     * [getICSDescription description]
     * @return [type] [description]
     */
    public function getICSDescription();

    /**
     * [getICSCategories description]
     * @return [type] [description]
     */
    public function getICSCategories();
}
