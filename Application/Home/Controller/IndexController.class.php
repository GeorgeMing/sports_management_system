<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller
{
    /**************以下是系统操作*****************/
    public function index()//主界面
    {
        $this->logincheck();
        $this->assign('name', session('name'));//右上角显示用户名


        $this->display();
//        SELECT grade,classNo
//FROM think_class ,think_stuinfo
//WHERE classId=id AND id=7
    }

    public function logincheck()//登录检查
    {
        $stuinfo = M("stuinfo");
        $no = session('no');
        $password = session('password');
        $studata = $stuinfo->where("no='%s'", $no)->find();
        if ($studata) {
            if ($studata['no'] == $no && $studata['password'] == $password) {
                return true;
            }
        }
        $this->error("还未登陆", U('login'));
    }

    public function login($no = null, $password = null)//登录操作
    {
        session(array('name' => 'session_id', 'expire' => 0));
        if ($no == null && $password == null) {
            $this->display();
        } else {
            $stuinfo = M("stuinfo");
            $studata = $stuinfo->where("no='%s'", $no)->find();
            if ($studata) {
                if ($studata['no'] == $no && $studata['password'] == $password) {
                    session('no', $no);
                    session('password', $password);
                    session('name', $studata['name']);
                    $this->success("登录成功!", "index");
                }
            }
            $this->error("用户名或密码错误!");
        }
    }

    public function loginout()//登出操作
    {
        session('no', null);
        session('password', null);
        session('name', null);
        $this->success('注销成功', U('login'));
    }


    public function changepassword($oldpassword = null, $newpassword = null, $newpassword2 = null) //修改密码
    {
        $this->logincheck();
        if ($oldpassword != null && $newpassword != null) {
            if ($newpassword2 != $newpassword) {
                $this->error("两次输入的新密码不相等");
            }
            $stuinfo = M('stuinfo');
            $no = session("no");
            $password = $stuinfo->where("no='%s'", $no)->getField("password");
            if ($password == $oldpassword) {
                $stuinfo->where("no='%s'", $no)->setField("password", $newpassword);
                session("password", $newpassword);
                $this->success("修改密码成功", U('index'));
            } else {
                $this->error("旧密码不正确");
            }
        } else {
            $this->display();
        }
    }
    public function register($no=null,$name=null,$sex=null,$grade=null,$classes=null,$password=null){
        if($no!=null){
            $InsertStuinfo = M("stuinfo");
            $data['no'] = $no;
            $data['name'] = $name;
            $data['password'] = $password;
            $data['sex'] = $sex;
            $data['classId']=$grade."".$classes;
            echo $no."".$name."".$password."".$sex."".$grade."".$classes;
            if($no&&$name&&$password&&$sex&&$grade&&$classes){
                $InsertStuinfo->add($data);
                $this -> success("添加成功!", "index");
            }
            else{
                $this->error("输入信息不完整或错误","register",1);
            }
        }
        else{
            $this->display();
        }

    }
    /**************以下是学生用户操作*****************/
    public function course_list(){//学生选课操作
        $this->logincheck();
        $this->assign('name', session('name'));//右上角显示用户名

        $show = M("course");
        $data = $show->select();//查询可以选的课程
        $this->assign('data',$data);//显示到模板

        $no = session('no');
        $show2 = M();
        $sql = "select a.courseName,a.adminId,a.courseId from think_course a,think_student_score b where a.courseId = b.courseId and b.no='".$no."'";
        $data2 = $show2->query($sql);
        $this->assign('data2',$data2);

        $this->display();
    }

    public function select_course($select = null,$cencel = null,$courseId = null){
        $this->logincheck();
        $select_course = M("student_score");
        $data['no']=session('no');
        $data['courseId']=$courseId;
        $data['score']=0;
        if($select == "选课"){
            $select_course->add($data);
            $this -> success("选课成功!", "course_list");
        }
        elseif($cencel == "取消"){
            $select_course ->where("courseid='%s' and no='%s'",$courseId,$data['no']) ->delete();
            $this -> success("取消选课!", "course_list");
        }
        else{

        }
    }
}
