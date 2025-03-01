#!/usr/bin/env php
<?php
/* Copyright (C) 2005 Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2005-2010 Laurent Destailleur <eldy@users.sourceforge.net>
 * Copyright (C) 2024       Frédéric France         <frederic.france@free.fr>
 * Copyright (C) 2025		MDW						<mdeweerd@users.noreply.github.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * \file scripts/withdrawals/build_withdrawal_file.php
 * \ingroup prelevement
 * \brief Script de prelevement
 */

if (!defined('NOSESSION')) {
	define('NOSESSION', '1');
}

$sapi_type = php_sapi_name();
$script_file = basename(__FILE__);
$path = __DIR__.'/';

// Test if batch mode
if (substr($sapi_type, 0, 3) == 'cgi') {
	echo "Error: You are using PHP for CGI. To execute ".$script_file." from command line, you must use PHP for CLI mode.\n";
	exit(1);
}

require_once $path."../../htdocs/master.inc.php";
require_once DOL_DOCUMENT_ROOT.'/core/lib/functionscli.lib.php';
require_once DOL_DOCUMENT_ROOT."/compta/prelevement/class/bonprelevement.class.php";
require_once DOL_DOCUMENT_ROOT."/compta/facture/class/facture.class.php";
require_once DOL_DOCUMENT_ROOT."/societe/class/societe.class.php";
require_once DOL_DOCUMENT_ROOT."/compta/paiement/class/paiement.class.php";
/**
 * @var DoliDB $db
 * @var HookManager $hookmanager
 */

// Global variables
$version = constant('DOL_VERSION');
$error = 0;

$hookmanager->initHooks(array('cli'));


/*
 * Main
 */

@set_time_limit(0);
print "***** ".$script_file." (".$version.") pid=".dol_getmypid()." *****\n";
dol_syslog($script_file." launched with arg ".implode(',', $argv));

$datetimeprev = dol_now();

$month = dol_print_date($datetimeprev, "%m");
$year = dol_print_date($datetimeprev, "%Y");

$user = new User($db);
$user->fetch(getDolGlobalInt('PRELEVEMENT_USER'));

if (!isset($argv[1])) { // Check parameters
	print "This script check invoices with a withdrawal request and\n";
	print "then create payment and build a withdraw file.\n";
	print "Usage: ".$script_file." simu|real\n";
	exit(1);
}

$withdrawreceipt = new BonPrelevement($db);
$result = $withdrawreceipt->create(getDolGlobalString('PRELEVEMENT_CODE_BANQUE'), getDolGlobalString('PRELEVEMENT_CODE_GUICHET'), $argv[1]);

$db->close();

exit(0);
