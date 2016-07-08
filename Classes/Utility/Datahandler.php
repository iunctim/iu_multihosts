<?php
namespace Iunctim\IuMultihosts\Utility;

class Datahandler {

   public static function addPageTree($params) {
      $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
      $beUserRepository = $objectManager->get("TYPO3\\CMS\\Beuser\\Domain\\Repository\\BackendUserRepository");   
      $beUserGroupRepository = $objectManager->get("TYPO3\\CMS\\Beuser\\Domain\\Repository\\BackendUserGroupRepository");  
      $pageRepository = $objectManager->get("TYPO3\\CMS\\Frontend\\Page\\PageRepository");   


      //be_user,be_group und page werden zuerst hinzugefügt und persistiert
      $beUserGroupUid = "NEW".$params['usergroup'];
      $beUserUid = "NEWUSER".$params['usergroup'];
      $pageUid = "NEWPAGE".$params['usergroup'];
      $metanaviPageUid = "NEWMETANAVIPAGE".$params['usergroup'];
      $searchPageUid = "NEWSEARCHPAGE".$params['usergroup'];
      $contactPageUid = "NEWCONTACTPAGE".$params['usergroup'];

      $searchPluginUid = "NEWSEARCHPLUGIN".$params['usergroup'];

      $data = array(
            'be_groups' => array(
               $beUserGroupUid => array(
                  'pid' => 0,
                  'title' => $params['usergroup'],
                  ),
               ),
            'be_users' => array(
               $beUserUid => array(
                  'pid' => 0,
                  'username' => $params['usergroup'],
                  'password' => md5($params['userpwd']),
                  'lang' => 'de',
                  ),
               ),
            'pages' => array(
               $pageUid => array(
                  'pid' => $params['pid'],
                  'title' => $params['title'],
                  'hidden' => 1,
                  'TSconfig' => '<INCLUDE_TYPOSCRIPT: source="DIR:fileadmin/TSconfig/Page/" extensions="ts">',
                  'is_siteroot' => '1',
                  ),
               $metanaviPageUid => array(
                  'pid' => $pageUid,
                  'title' => "Metanavi",
                  "doktype" => "199",
                  ),
               $searchPageUid => array(
                  'pid' => $metanaviPageUid,
                  'title' => "Search",
                  ),
               $contactPageUid => array(
                  'pid' => $metanaviPageUid,
                  'title' => "Contact",
                  ),
               ),
            'tt_content' => array(
               $searchPluginUid => array(
                  'pid' => $searchPageUid,
                  'header' => "Search",
                  'list_type' => "indexedsearch_pi2",
                  'CType' => "list",
                  ),
               ),

            );

      $tce = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');
      $tce->stripslashes_values = 0;
      $tce->start($data, array());
      $tce->process_datamap();
      $tce->clear_cacheCmd('pages');

      //Get the previously added beUser, beGroup and Page
      $beUser = $beUserRepository->findByUsername($params['usergroup'])->getFirst();
      $beGroup = $beUserGroupRepository->findByTitle($params['usergroup'])->getFirst();
      $awiEditorBeGroup = $beUserGroupRepository->findByTitle("awi editors")->getFirst();


      //Get the rootpage UID
      $newPage = $GLOBALS['TYPO3_DB']->sql_query('SELECT * FROM pages WHERE title="'.$params['title'].'" AND deleted=0')->fetch_assoc();
      $pageUid = $newPage['uid'];

      //Get the metanavi page UID
      $newMetanaviPage = $GLOBALS['TYPO3_DB']->sql_query('SELECT * FROM pages WHERE pid='.$pageUid.' AND title="Metanavi" AND deleted=0')->fetch_assoc();
      $metanaviPageUid = $newMetanaviPage['uid'];

      //Get the search page UID
      $newSearchPage = $GLOBALS['TYPO3_DB']->sql_query('SELECT * FROM pages WHERE pid='.$metanaviPageUid.' AND title="Search" AND deleted=0')->fetch_assoc();
      $searchPageUid = $newSearchPage['uid'];

      //Get the contact page UID
      $newContactPage = $GLOBALS['TYPO3_DB']->sql_query('SELECT * FROM pages WHERE pid='.$metanaviPageUid.' AND title="Contact" AND deleted=0')->fetch_assoc();
      $contactPageUid = $newContactPage['uid'];




      $subgroups = "";
      $pages = array();
      //Überprüfe welche Extensions aktiviert sind
      foreach($params['extensions'] as $extension) {
         $extensionGroup = $beUserGroupRepository->findByTitle($extension)->getFirst();      

         /*Die be_group wird allen Extensiongruppen zugeordnet (Untergruppen)*/
         if($extensionGroup)
            $subgroups .= $extensionGroup->getUid().","; 

         $pages["NEWFOLDER$extension"] = array(
               "pid" => $pageUid,
               "title" => $extension,
               "module" => $extension,
               "doktype" => "254",
               "hidden" => 0,
               'perms_groupid' => $beGroup->getUid(),
               );    

      }

      $subgroups = rtrim($subgroups,",");

      $usergroups = $beGroup->getUid();
      if($awiEditorBeGroup) {
         $usergroups .= "," . $awiEditorBeGroup->getUid();
      }

      //Setze GruppenId der Root-Seite
      $pages[$pageUid] = array(
            'perms_groupid' => $beGroup->getUid(),
            );

      $sysFileStorageID = "NEWSTORAGE".$params['title'];
      //Der rest wird hinzugefügt. be_user und page werden aktualisiert.
      $data = array(
            'be_users' => array(
               $beUser->getUid() => array(
                  'usergroup' => $usergroups,
                  ),
               ),
            'be_groups' => array(
               $beGroup->getUid() => array(
                  'subgroup' => $subgroups,
                  ),
               ),
            'pages' => $pages,
            'sys_domain' => array(
               $params['title'] => array(
                  'pid' => $pageUid,
                  'domainName' => $params['url'],
                  ),
               ),
            'sys_file_storage' => array(
               $sysFileStorageID => array(
                  'pid' => 0,
                  'name' => $params['title'],
                  'configuration' => "<T3FlexForms>
                  <data>
                  <sheet index=\"sDEF\">
                  <language index=\"lDEF\">
                  <field index=\"basePath\">
                  <value index=\"vDEF\">fileadmin/user_upload/".$params['url']."</value>
                  </field>
                  <field index=\"pathType\">
                  <value index=\"vDEF\">relative</value>
                  </field>
                  <field index=\"caseSensitive\">
                  <value index=\"vDEF\">1</value>
                  </field>
                  </language>
                  </sheet>
                  </data>
                  </T3FlexForms>",
                  ),
                  ),
                  );

      $tce->start($data, array());
      $tce->process_datamap();
      $tce->clear_cacheCmd('pages');

      /*Define storage ID constants in typoscript*/
      $extensionConstants = "";
      $extensionFolders = $pageRepository->getRecordsByField("pages","pid",$pageUid);
      foreach($extensionFolders as $extensionFolder) {
         if($extensionFolder['doktype'] == "254") {
            $extensionConstants .= $extensionFolder['title']."_storagefolder_pid=".$extensionFolder['uid']."\r\n"; 
         }
      }

      $inactiveConstants="#socialmediamenu_pid=\r\n#footermenu_pid=\r\n"; 

      /**/                  
      $sysFileStorage = $GLOBALS['TYPO3_DB']->sql_query("SELECT * FROM sys_file_storage WHERE name='".$params['title']."'")->fetch_assoc();


      //Dritter Durchlauf: ExtensionTemplate mit allen Konstanten wird angelegt.
      $data = array( 
            'sys_template' => array(
               $params['title'] => array(
                  'pid' => $pageUid,
                  'title' => '+ext',
                  'constants' => "default_lang=".$params['language']."\r\ncolor_scheme=".$params['color']."\r\nsite.piwik.siteId=".$params['piwik']."\r\nrootpage_id=$pageUid\r\ncontact_pid=$contactPageUid\r\nsearch_pid=$searchPageUid\r\nmetanavi_pid=$metanaviPageUid\r\n".$inactiveConstants.$extensionConstants,
                  'config' => "config.simulateStaticDocuments = 0\r\nconfig.baseURL = http://".$params['url']."/\r\nconfig.tx_realurl_enable = 1\r\n",
                  'basedOn' => 19,
                  'root' => 1,
                  ),
               ),
            'sys_filemounts' => array(
               $params['title'] => array(
                  'pid' => 0,
                  'title' => $params['title'],
                  'base' => $sysFileStorage['uid'],
                  'path' => "/",
                  )
               ),
            ); 

      $tce->start($data, array());
      $tce->process_datamap();
      $tce->clear_cacheCmd('pages');

      $sysFileMount = $GLOBALS['TYPO3_DB']->sql_query("SELECT * FROM sys_filemounts WHERE title='".$params['title']."'")->fetch_assoc();

      $data = array(
            "be_groups" => array(
               $beGroup->getUid() => array(
                  'db_mountpoints' => $pageUid, 
                  'file_mountpoints' => $sysFileMount['uid'], 
                  ), 
               ),
            );

      

      $tce->start($data, array());
      $tce->process_datamap();
      $tce->clear_cacheCmd('pages');

      \TYPO3\CMS\Backend\Utility\BackendUtility::setUpdateSignal('updatePageTree');

      /*Add the RealUrl Conf for the new Domain*/
      self::addRealUrlConf($pageUid,$params['url']);
   }

   public function disablePageTree(\Iunctim\IuMultihosts\Domain\Model\Host $host) {  
      $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
      $beUserRepository = $objectManager->get("TYPO3\\CMS\\Beuser\\Domain\\Repository\\BackendUserRepository"); 
      $beUserGroupRepository = $objectManager->get("TYPO3\\CMS\\Beuser\\Domain\\Repository\\BackendUserGroupRepository");  

      $page = $GLOBALS['TYPO3_DB']->sql_query('SELECT * FROM pages WHERE title="'.$host->getTitle().'" AND is_siteroot=1 AND doktype=1 AND deleted=0')->fetch_assoc();
      $pageUid = intval($page['uid']);

      if($pageUid === 0) return;      

      /* First: get all pages inside the pagetree */
      $subpages = self::getSubpages($pageUid);

      /* Prepare the page data for the datahandler */
      $pageData = $pageUid?array($pageUid => array("delete" => 1)):NULL; 
      if($pageUid) {
         $GLOBALS['TYPO3_DB']->sql_query("UPDATE pages SET deleted=1 WHERE uid=$pageUid");
      }
      foreach($subpages as $subpage) {
         $GLOBALS['TYPO3_DB']->sql_query("UPDATE pages SET deleted=1 WHERE uid=$subpage");
      }

      $beUser = $beUserRepository->findByUsername($host->getTitle())->getFirst();
      $beGroup = $beUserGroupRepository->findByTitle($host->getTitle())->getFirst();

      if($beUser) {
         $GLOBALS['TYPO3_DB']->sql_query("UPDATE be_users SET deleted=1 WHERE uid=" . $beUser->getUid());
      } 
      if($beGroup) {
         $GLOBALS['TYPO3_DB']->sql_query("UPDATE be_groups SET deleted=1 WHERE uid=" . $beGroup->getUid());
      }

      $GLOBALS['TYPO3_DB']->sql_query("UPDATE sys_file_storage SET deleted=1 WHERE name='".$host->getTitle()."'");

      $GLOBALS['TYPO3_DB']->sql_query("UPDATE sys_filemounts SET deleted=1 WHERE name='".$host->getTitle()."'");

      /*Delete the Domain Record*/
      $GLOBALS['TYPO3_DB']->sql_query("DELETE FROM sys_domain WHERE pid=$pageUid");


      $mountFolder = PATH_site . 'fileadmin/user_upload/'.$host->getUrl(); 

      if (is_dir($mountFolder)) {
         self::rrmdir($mountFolder);
      }


      self::deleteRealUrlConf($host->getUrl());

      $code = '<?php 
         $TYPO3_CONF_VARS[\'EXTCONF\'][\'realurl\'][\''.$url.'\'][\'pagePath\'][\'rootpage_id\'] = '.$rootpageId.'; 
         $TYPO3_CONF_VARS[\'EXTCONF\'][\'realurl\'][\''.$url.'\'] = $TYPO3_CONF_VARS[\'EXTCONF\'][\'realurl\'][\'_DEFAULT\'];
      ?>';


      file_put_contents($realurlconfPath,$code);

   }

   protected static function addRealUrlConf($rootpageId,$url) {
      $realurlconfsFolder = PATH_typo3conf.'realurl_confs'; 
      if (!file_exists($realurlconfsFolder)) {
         mkdir($realurlconfsFolder, 0774, true);
      } 

      $realurlconfFile = str_replace('/','_',$url).".php"; 

      $realurlconfPath = $realurlconfsFolder. "/". $realurlconfFile;


      $code = '<?php 
         $TYPO3_CONF_VARS[\'EXTCONF\'][\'realurl\'][\''.$url.'\'][\'pagePath\'][\'rootpage_id\'] = '.$rootpageId.'; 
      $TYPO3_CONF_VARS[\'EXTCONF\'][\'realurl\'][\''.$url.'\'] = $TYPO3_CONF_VARS[\'EXTCONF\'][\'realurl\'][\'_DEFAULT\'];
      ?>'; 


      file_put_contents($realurlconfPath,$code);
   }

   protected static function deleteRealUrlConf($url) {
      $realurlconfsFolder = PATH_typo3conf.'realurl_confs'; 
      $realurlconfFile = str_replace('/','_',trim($url)).".php";

      $realurlconfPath = $realurlconfsFolder. "/". $realurlconfFile;

      error_log($realurlconfPath);
      if(file_exists($realurlconfPath)) {
         unlink($realurlconfPath);
      }

   }

   public static function checkUrlFormat($url) {
      $regex = '#^(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$#';
      return preg_match($regex, $url);
   }

   public static function checkDns($url) {
      $hostIp = "134.119.10.250";
      $dns = dns_get_record($url, DNS_A);
      if ($dns['ip'] != $hostIp) {
         return false;
      }
      return true;
   }

   public static function addPiwikSite($url, $title, $user, $email, $pass) {
      // check if domain already exists in Piwik:
      $siteId = null;
      $allSites = Datahandler::callPiwikApi("method=SitesManager.getAllSites");
      foreach ($allSites as $site) {
         if( preg_replace('#^https?://#', '', $site['main_url']) == $url ) {
            $siteId = $site['idsite'];
      }
      }

      // else create it:
      if (is_null($siteId)) {
         $siteId = Datahandler::callPiwikApi("method=SitesManager.addSite&siteName=$title&urls=$url");
      }
      // create user if user does not exist yet:
      $userExists = Datahandler::callPiwikApi("method=UsersManager.userExists&userLogin=$user&serialize=0");
      $emailExists = Datahandler::callPiwikApi("method=UsersManager.userEmailExists&userEmail=$email&serialize=0");
      if (!$userExists && !$emailExists) {
         Datahandler::callPiwikApi("method=UsersManager.addUser&userLogin=$user&password=$pass&email=$email");
      } else {
         if ($emailExists) {
            $existingUser = Datahandler::callPiwikApi("method=UsersManager.getUserLoginFromUserEmail&userEmail=$email");
            if ($existingUser != $user) {
               return "E-Mail is already used by another user account!";
            }
         }
      }

      // set user access for new website entry:
      $test = Datahandler::callPiwikApi("method=UsersManager.setUserAccess&userLogin=$user&access=view&idSites=$siteId");
      //return array("access" => "Piwik website entry $siteId successfully created!");
      return $siteId;
   }

   public static function callPiwikApi($queryString) {
      error_reporting(E_ALL & ~E_NOTICE);
      $piwikApi = "http://awi.iunctim.com/piwik/?module=API&format=PHP&token_auth=e0e7b0e0f181bd45704a2e3f869c3cb4&";
      $fetched = file_get_contents($piwikApi . $queryString);
      $result = unserialize($fetched);
      if (json_last_error() == JSON_ERROR_NONE) {
         if (!$result) {
            return false;
         } else {
            return $result;
         }

      } else {
         return false;
      }
   }

   public static function generatePassword($length = 8) {
      $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789,.-;:_+#*!§$%&/()=';
      $count = mb_strlen($chars);
      for ($i = 0, $result = ''; $i < $length; $i++) {
         $index = rand(0, $count - 1);
         $result .= mb_substr($chars, $index, 1);
      }
      return $result;
   }

   protected static function getSubpages($pageUid) {
      $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
      $pageRepository = $objectManager->get("TYPO3\\CMS\\Frontend\\Page\\PageRepository");   
      $pageDataProvider = $objectManager->get("TYPO3\\CMS\\Backend\\Tree\\Pagetree\\DataProvider");   


      /* First: get all pages inside the pagetree */
      $pageNode = \TYPO3\CMS\Backend\Tree\Pagetree\Commands::getNode($pageUid);
      $subnodes = $pageDataProvider->getNodes($pageNode); 
      $subpages = array();

      foreach($subnodes as $subnode) {
         $subpageid = $subnode->getId();
         $subpages[] = $subpageid;

         $subpages = array_merge($subpages,self::getSubpages($subpageid));
      }

      return $subpages;
   }

   protected static function rrmdir($dir) { 
      if (is_dir($dir)) { 
        $objects = scandir($dir); 
        foreach ($objects as $object) { 
          if ($object != "." && $object != "..") { 
            if (is_dir($dir."/".$object))
              self::rrmdir($dir."/".$object);
            else
              unlink($dir."/".$object); 
          } 
        }
        rmdir($dir); 
      } 
    }

}

?>
