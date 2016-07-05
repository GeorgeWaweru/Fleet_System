<?php
class AuthenticateRoute
{
	public function showLogout()
	{
		$USER_CHANGED_PASSWORD=isset($_SESSION['USER_CHANGED_PASSWORD']) ? intval($_SESSION['USER_CHANGED_PASSWORD']) : 0;
		if($USER_CHANGED_PASSWORD>0){
			return 1;
		}else{
			return 0;
		}
	}
	public function AllowRoute($level)
	{
		$ADMIN_USER_ROLE_NAME=isset($_SESSION['ADMIN_USER_ROLE_NAME']) ? $_SESSION['ADMIN_USER_ROLE_NAME'] : "";
		$ADMIN_USER_ROLE_LEVEL=isset($_SESSION['ADMIN_USER_ROLE_LEVEL']) ? $_SESSION['ADMIN_USER_ROLE_LEVEL'] : "";	
		$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
		$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? $_SESSION['LOGGED_IN_USER_ID'] : "";
		$USER_CHANGED_PASSWORD=isset($_SESSION['USER_CHANGED_PASSWORD']) ? intval($_SESSION['USER_CHANGED_PASSWORD']) : 0;
		
		if($USER_CHANGED_PASSWORD>0)
		{
			if($LOGGED_IN_USER_KIND=='admin_user'){
				if($level=='profile' || $level=='manifesto'){
					 $return_value= 0;
				}else{
					 $return_value= 1;
				}
				  
			}else if($LOGGED_IN_USER_KIND=='candidate_user'){
				if($level=='profile' || $level=='manifesto' || $level=='achivements' || $level=='questions' || $level=='candidate'){
					$return_value = 1;
				}else{
					$return_value = 0;
				}
			}else if($LOGGED_IN_USER_KIND=='candidate_admin_user'){
				
						$Candidate_areas=AccountAdminAreas::model()->findAllByAttributes(array('account_id'=>$LOGGED_IN_USER_ID));
						$actions_array=array();
						foreach($Candidate_areas as $item)
						{
							$admin_area_id=$item->admin_area_id;
							$ActionsAdminAreas=AdminAreas::model()->findByPk($admin_area_id);	
							$is_manifesto=$ActionsAdminAreas->is_manifesto;
							$is_profile=$ActionsAdminAreas->is_profile;
							$is_questions=$ActionsAdminAreas->is_questions;
							$is_achievements=$ActionsAdminAreas->is_achievements;
							if($is_manifesto==1){
								$actions_array[]='manifesto';
							}else if($is_profile==1){
								$actions_array[]='profile';
							}else if($is_questions==1){
								$actions_array[]='questions';
							}else if($is_achievements==1){
								$actions_array[]='achivements';
							}
						}
							if(in_array($level,$actions_array)){
								$return_value = 1;
							}else{
								$return_value = 0;
							}
				
			}
				if(!empty($return_value)){
					return $return_value;
				}else{
					return 0;
				}
				
		}else{
			return 0;
		}
	}
}
?>