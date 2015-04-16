<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 9/3/14
 * Time: 3:45 PM
 */

class WebUser extends CWebUser
{
    /**
     * Overrides a Yii method that is used for roles in controllers (accessRules).
     *
     * @param string $operation Name of the operation required (here, a role).
     * @param mixed $params (opt) Parameters for this operation, usually the object to access.
     * @return bool Permission granted?
     */
    public function checkAccess($operation, $params=array())
    {
        if(empty($this->id))
        {
            // Not identified => no rights
            return false;
        }

        $role = $this->getState("roles");


        if($role === 'admin')
        {
            return true; // admin role has access to everything
        }

        if($this->id == $params)
        {
            return false;

        }


        // allow access if the operation request is the current user's role
            return ($operation === $role);
    }


    public function checkAccessById($id)
    {
        if($this->getState('userId') == $id)
        {
            return true;
        }
        else
        {
//            throw new CHttpException(403, 'You are not authorized to perform this action.');
            return false;
        }
    }




}






