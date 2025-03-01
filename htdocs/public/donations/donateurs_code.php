<?php
/* Copyright (C) 2002       Rodolphe Quiedeville    <rodolphe@quiedeville.org>
 * Copyright (C) 2018-2025  Frédéric France         <frederic.france@free.fr>
 * Copyright (C) 2025		MDW						<mdeweerd@users.noreply.github.com>
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
 *	    \file       htdocs/public/donations/donateurs_code.php
 *      \ingroup    donation
 *		\brief      Page to list donators
 */

if (!defined('NOLOGIN')) {
	define('NOLOGIN', '1');
}
if (!defined('NOBROWSERNOTIF')) {
	define('NOBROWSERNOTIF', '1');
}
if (!defined('NOIPCHECK')) {
	define('NOIPCHECK', '1'); // Do not check IP defined into conf $dolibarr_main_restrict_ip
}

// C'est un wrapper, donc header vierge
/**
 * Header function
 *
 * Note: also called by functions.lib:recordNotFound
 *
 * @param 	string		$title				Title
 * @param 	string		$head				Head array
 * @param 	int    		$disablejs			More content into html header
 * @param 	int    		$disablehead		More content into html header
 * @param 	string[]|string	$arrayofjs			Array of complementary js files
 * @param 	string[]|string	$arrayofcss			Array of complementary css files
 * @return	void
 */
function llxHeaderVierge($title, $head = "", $disablejs = 0, $disablehead = 0, $arrayofjs = [], $arrayofcss = [])  // @phan-suppress-current-line PhanRedefineFunction
{
	print '<html><title>List of donators</title><body>';
}
/**
 * Footer function
 *
 * Note: also called by functions.lib:recordNotFound
 *
 * @return	void
 */
function llxFooterVierge()  // @phan-suppress-current-line PhanRedefineFunction
{
	print '</body></html>';
}

// Load Dolibarr environment
require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/don/class/don.class.php';

// Security check
if (!isModEnabled('don')) {
	httponly_accessforbidden('Module Donation not enabled');
}


$langs->load("donations");


/*
 * View
 */

llxHeaderVierge("");

$sql = "SELECT d.datedon as datedon, d.lastname, d.firstname, d.amount, d.public, d.societe";
$sql .= " FROM ".MAIN_DB_PREFIX."don as d";
$sql .= " WHERE d.fk_statut in (2, 3) ORDER BY d.datedon DESC";

$resql = $db->query($sql);
if ($resql) {
	$num = $db->num_rows($resql);
	if ($num) {
		print '<table class="centpercent" cellspacing="0" cellpadding="4">';

		print '<tr>';
		print "<td>".$langs->trans("Name")." / ".$langs->trans("Company")."</td>";
		print "<td>Date</td>";
		print '<td class="right">'.$langs->trans("Amount").'</td>';
		print "</tr>\n";

		while ($i < $num) {
			$objp = $db->fetch_object($resql);

			print '<tr class="oddeven">';
			if ($objp->public) {
				print "<td>".dolGetFirstLastname($objp->firstname, $objp->lastname)." ".dol_escape_htmltag($objp->societe)."</td>\n";
			} else {
				print "<td>".$langs->trans("Anonymous")."</td>\n";
			}
			print "<td>".dol_print_date($db->jdate($objp->datedon))."</td>\n";
			print '<td class="right">'.price($objp->amount).' '.$langs->trans("Currency".$conf->currency).'</td>';
			print "</tr>";
			$i++;
		}
		print "</table>";
	} else {
		print $langs->trans("Donation");
	}
} else {
	dol_print_error($db);
}

$db->close();

llxFooterVierge();
