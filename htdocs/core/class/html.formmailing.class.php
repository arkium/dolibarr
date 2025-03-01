<?php
/* Copyright (C) 2014 Florian Henry florian.henry@open-concept.pro
 * Copyright (C) 2024		MDW							<mdeweerd@users.noreply.github.com>
 *
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program. If not, see <https://www.gnu.org/licenses/>.
*/

/**
 *	\file       htdocs/core/class/html.formmailing.class.php
 *  \ingroup    core
 *	\brief      File of predefined functions for HTML forms for mailing module
 */
require_once DOL_DOCUMENT_ROOT.'/core/class/html.form.class.php';

/**
 *  Class to offer components to list and upload files
 */
class FormMailing extends Form
{
	/**
	 * @var string[] Error codes (or messages)
	 */
	public $errors = array();


	/**
	 * Output a select with destinaries status
	 *
	 * @param 	string  $selectedid     	The selected id
	 * @param 	string  $htmlname       	Name of controm
	 * @param 	integer $show_empty     	Show empty option
	 * @param	string	$morecss			More CSS
	 * @return 	string 						HTML select
	 */
	public function selectDestinariesStatus($selectedid = '', $htmlname = 'dest_status', $show_empty = 0, $morecss = 'minwidth75')
	{
		global $langs;

		$langs->load("mails");

		require_once DOL_DOCUMENT_ROOT.'/comm/mailing/class/mailing.class.php';
		$mailing = new Mailing($this->db);

		$options = array();

		$options += $mailing->statut_dest;

		// Note -1 is used for error, so we use -2 for tempty value
		return Form::selectarray($htmlname, $options, $selectedid, ($show_empty ? -2 : 0), 0, 0, '', 1, 0, 0, '', $morecss);
	}
}
