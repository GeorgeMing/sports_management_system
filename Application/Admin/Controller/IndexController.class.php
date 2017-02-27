<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index(){
        $this->logincheck();
        $this->assign('list', 'index');
        $this->assign('username', session('name'));
        $this->display();
    }


    //检查是否登录
    public function logincheck(){
        $admininfo = M("admin");
        $username = session('username');
        $password = session('password');
        $admindata = $admininfo -> where("username='%s'", $username) -> find();
        if($admindata){
            if($admindata['username'] == $username && $admindata['password'] == $password){
               return true;
            }
        }
        $this->error("还未登陆", U('login'));
    }


    //登录
    public function login($username = null, $password = null){
        session(array('name'=>'session_id','expire'=>0));
        if($username == null && $password == null){
            $this -> display();
        } else {
            $admininfo = M("admin");
            $admindata = $admininfo -> where("username='%s'", $username) -> find();
            if($admindata){
                if($admindata['username'] == $username && $admindata['password'] == $password){
                    session('username', $username);
                    session('password', $password);
                    session('name', $admindata['name']);
                    $this -> success("登录成功!", "index");
                }
            }
            $this -> error("用户名或密码错误!");
        }
    }

    //注销
    public function loginout(){
        session('username', null);
        session('password', null);
        session('name', null);
        $this->success('注销成功', U('login'));
    }

    //修改密码
    public function changepassword($oldpassword = null, $newpassword = null, $newpassword2 = null){
        $this->logincheck();
        if($oldpassword != null && $newpassword != null){
            if($newpassword2 != $newpassword){
                $this->error("两次输入的新密码不相等");
            }
            $admininfo = M('Admin');
            $username = session("username");
            $password = $admininfo->where("username='%s'", $username)->getField("password");
            if($password == $oldpassword){
                $admininfo->where("username='%s'", $username)->setField("password", $newpassword);
                session("password", $newpassword);
                $this->success("修改密码成功", U('index'));
            }else{
                $this->error("旧密码不正确");
            }
        }else{
            $this->display();
        }

    }


    /*******************成绩管理*******************/
    public function score(){
        $this->logincheck();
        $this->assign('list', 'score');
        $this->assign('username', session('name'));

        $courseinfo = M('Course');
        $admininfo = M('Admin');
        $adminId = $admininfo->where("username='%s'", session('username'))->getField('id');
        $courseinfo = $courseinfo->where("adminId=".$adminId)->select();//获取该老师开设的课程
        $this->assign('courselist', $courseinfo);
        $this->display();
    }

    //对当前课堂进行成绩录入工作
    public function addscore($classid = null){
        $this->logincheck();
        $this->assign('list', 'score');
        $this->assign('username', session('username'));
        $this->display();
    }

    /******************管理员管理********************/
    public function adminadmin($fileid = null, $filecomm = null){
        $this->logincheck();
        $this->assign('list', 'file');
        $this->assign('username', session('name'));
        switch ($filecomm){
            case "download":break;
            case "upload":break;
            default:
                $this->display();
                break;
            }
    }

//    //文件下载
//    private function fileDownload(){
//
//    }
//    //文件上传
//    private function fileUpload(){
//
//    }



    /**************test***************/
    public function test(){
        $data["1"] = 1;
        $data["2"] = 2;
        $jsondata = json_encode($data);
        $db = M('Course');
        $db->where("courseId=1")->setField("classRangeId", $jsondata);
    }
}