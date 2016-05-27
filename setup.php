<?php
/*
 * @version $Id: HEADER 15930 2011-10-25 10:47:55Z jmd $
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2011 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

// ----------------------------------------------------------------------
// Original Author of file:
// Purpose of file:
// ----------------------------------------------------------------------

// Init the hooks of the plugins -Needed
function plugin_init_slackglpi() {
   global $PLUGIN_HOOKS,$CFG_GLPI;

   // Params : plugin name - string type - ID - Array of attributes
   // No specific information passed so not needed
   //Plugin::registerClass('PluginExampleExample',
   //                      array('classname'              => 'PluginExampleExample',
   //                        ));

   Plugin::registerClass('PluginSlackGlpiConfig', array('addtabon' => 'Config'));

   // Params : plugin name - string type - ID - Array of attributes
   Plugin::registerClass('PluginSlackGlpiDropdown');

  
   // Display a menu entry ?
   // $_SESSION["glpi_plugin_example_profile"]['example'] = 'w';
   // if (isset($_SESSION["glpi_plugin_example_profile"])) { // Right set in change_profile hook
   //    $PLUGIN_HOOKS['menu_toadd']['example'] = array('plugins' => 'PluginExampleExample',
   //                                                  'tools'   => 'PluginExampleExample');
      
      // Old menu style
//       $PLUGIN_HOOKS['menu_entry']['example'] = 'front/example.php';
// 
//       $PLUGIN_HOOKS['submenu_entry']['example']['options']['optionname']['title'] = "Search";
//       $PLUGIN_HOOKS['submenu_entry']['example']['options']['optionname']['page']  = '/plugins/example/front/example.php';
//       $PLUGIN_HOOKS['submenu_entry']['example']['options']['optionname']['links']['search'] = '/plugins/example/front/example.php';
//       $PLUGIN_HOOKS['submenu_entry']['example']['options']['optionname']['links']['add']    = '/plugins/example/front/example.form.php';
//       $PLUGIN_HOOKS['submenu_entry']['example']['options']['optionname']['links']['config'] = '/plugins/example/index.php';
//       $PLUGIN_HOOKS['submenu_entry']['example']['options']['optionname']['links']["<img  src='".$CFG_GLPI["root_doc"]."/pics/menu_showall.png' title='".__s('Show all')."' alt='".__s('Show all')."'>"] = '/plugins/example/index.php';
//       $PLUGIN_HOOKS['submenu_entry']['example']['options']['optionname']['links'][__s('Test link', 'example')] = '/plugins/example/index.php';

   //    $PLUGIN_HOOKS["helpdesk_menu_entry"]['example'] = true;
   // }

   // Config page
   if (Session::haveRight('config',UPDATE)) {
      $PLUGIN_HOOKS['config_page']['PluginSlackGlpi'] = 'config.php';
   }

   // Init session
   //$PLUGIN_HOOKS['init_session']['example'] = 'plugin_init_session_example';
   // Change profile
   // $PLUGIN_HOOKS['change_profile']['example'] = 'plugin_change_profile_example';
   // Change entity
   //$PLUGIN_HOOKS['change_entity']['example'] = 'plugin_change_entity_example';

   // Item action event // See define.php for defined ITEM_TYPE
   // $PLUGIN_HOOKS['pre_item_update']['example'] = array('Computer' => 'plugin_pre_item_update_example');
   $PLUGIN_HOOKS['item_update']['PluginSlackGlpi']     = array('Computer' => 'plugin_item_update_SlackGlpi');

   // $PLUGIN_HOOKS['item_empty']['example']     = array('Computer' => 'plugin_item_empty_example');

   // // Example using a method in class
   // $PLUGIN_HOOKS['pre_item_add']['example']    = array('Computer' => array('PluginExampleExample',
   //                                                                         'pre_item_add_computer'));
   // $PLUGIN_HOOKS['post_prepareadd']['example'] = array('Computer' => array('PluginExampleExample',
   //                                                                         'post_prepareadd_computer'));
   // $PLUGIN_HOOKS['item_add']['example']        = array('Computer' => array('PluginExampleExample',
   //                                                                         'item_add_computer'));

   // $PLUGIN_HOOKS['pre_item_delete']['example'] = array('Computer' => 'plugin_pre_item_delete_example');
   // $PLUGIN_HOOKS['item_delete']['example']     = array('Computer' => 'plugin_item_delete_example');

   // Example using the same function
   // $PLUGIN_HOOKS['pre_item_purge']['example'] = array('Computer' => 'plugin_pre_item_purge_example',
   //                                                    'Phone'    => 'plugin_pre_item_purge_example');
   // $PLUGIN_HOOKS['item_purge']['example']     = array('Computer' => 'plugin_item_purge_example',
   //                                                    'Phone'    => 'plugin_item_purge_example');

   // // Example with 2 different functions
   // $PLUGIN_HOOKS['pre_item_restore']['example'] = array('Computer' => 'plugin_pre_item_restore_example',
   //                                                       'Phone'   => 'plugin_pre_item_restore_example2');
   // $PLUGIN_HOOKS['item_restore']['example']     = array('Computer' => 'plugin_item_restore_example');

   // // Add event to GLPI core itemtype, event will be raised by the plugin.
   // // See plugin_example_uninstall for cleanup of notification
   // $PLUGIN_HOOKS['item_get_events']['example']
   //                               = array('NotificationTargetTicket' => 'plugin_example_get_events');

   // // Add datas to GLPI core itemtype for notifications template.
   // $PLUGIN_HOOKS['item_get_datas']['example']
   //                               = array('NotificationTargetTicket' => 'plugin_example_get_datas');

   // $PLUGIN_HOOKS['item_transfer']['example'] = 'plugin_item_transfer_example';

   // function to populate planning
   // No more used since GLPI 0.84
   // $PLUGIN_HOOKS['planning_populate']['example'] = 'plugin_planning_populate_example';
   // Use instead : add class to planning types and define populatePlanning in class
   // $CFG_GLPI['planning_types'][] = 'PluginExampleExample';

   //function to display planning items
   // No more used sinc GLPi 0.84
   // $PLUGIN_HOOKS['display_planning']['example'] = 'plugin_display_planning_example';
   // Use instead : displayPlanningItem of the specific itemtype

   // Massive Action definition
   // $PLUGIN_HOOKS['use_massive_action']['example'] = 1;

   // $PLUGIN_HOOKS['assign_to_ticket']['example'] = 1;

   // Add specific files to add to the header : javascript or css
   // $PLUGIN_HOOKS['add_javascript']['example'] = 'example.js';
   // $PLUGIN_HOOKS['add_css']['example']        = 'example.css';

   // request more attributes from ldap
   //$PLUGIN_HOOKS['retrieve_more_field_from_ldap']['example']="plugin_retrieve_more_field_from_ldap_example";

   // Retrieve others datas from LDAP
   //$PLUGIN_HOOKS['retrieve_more_data_from_ldap']['example']="plugin_retrieve_more_data_from_ldap_example";

   // Reports
   // $PLUGIN_HOOKS['reports']['example'] = array('report.php'       => 'New Report',
   //                                            'report.php?other' => 'New Report 2');

   // // Stats
   // $PLUGIN_HOOKS['stats']['example'] = array('stat.php'       => 'New stat',
   //                                           'stat.php?other' => 'New stats 2',);

   $PLUGIN_HOOKS['post_init']['PluginSlackGlpi'] = 'plugin_slackglpi_postinit';

   $PLUGIN_HOOKS['status']['PluginSlackGlpi'] = 'plugin_slackglpi_Status';
   
   // CSRF compliance : All actions must be done via POST and forms closed by Html::closeForm();
   $PLUGIN_HOOKS['csrf_compliant']['PluginSlackGlpi'] = true;

   $PLUGIN_HOOKS['display_central']['PluginSlackGlpi'] = "plugin_slackglpi_display_central";
   $PLUGIN_HOOKS['display_login']['PluginSlackGlpi'] = "plugin_slackglpi_display_login";
}


// Get the name and the version of the plugin - Needed
function plugin_version_example() {

   return array('name'           => 'Slack notifier',
                'version'        => '0.1',
                'author'         => 'Bertrand ENNOUCHY',
                'license'        => 'GPLv2+',
                'homepage'       => 'https://github.com/Sburb/glpi-slack',
                'minGlpiVersion' => '0.85');// For compatibility / no install in version < 0.80
}


// Optional : check prerequisites before install : may print errors or add to message after redirect
function plugin_example_check_prerequisites() {

   // Strict version check (could be less strict, or could allow various version)
   if (version_compare(GLPI_VERSION,'0.85','lt') /*|| version_compare(GLPI_VERSION,'0.84','gt')*/) {
      echo "This plugin requires GLPI >= 0.85";
      return false;
   }
   return true;
}


// Check configuration process for plugin : need to return true if succeeded
// Can display a message only if failure and $verbose is true
function plugin_example_check_config($verbose=false) {
   if (true) { // Your configuration check
      return true;
   }

   if ($verbose) {
      _e('Installed / not configured', 'example');
   }
   return false;
}
?>