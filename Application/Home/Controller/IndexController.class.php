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
        $no = session('no');
        dump($no);
        $show2 = M();
        $sql = "select a.courseName,a.adminId,a.courseId from think_course a,think_student_score b where a.courseId = b.courseId and b.no='".$no."'";
        $data2 = $show2->query($sql);//查询当前登录学生所选的课程
        $this->assign('data2',$data2);
        dump($data2);
        $stu = M("stuinfo");
        $stu_info = $stu->where("no='%s'", $no)->select();//从学生表中提取班级编号
        //dump($stu_info[0]['classid']);//班级编号

        $show1 = M("course");
        $data1 = $show1->select();//查询可以选的课程
//        dump($data1);
        for($j=0;$j<100;$j++){//注意这里仅仅是100,没有查表,反正可以自己break，尽量调大就好！！！
            $classes[$j] = json_decode($data1[$j]['classrangeid'], true);//把json数据解析为array格式
            if($classes[$j]==null)//遍历到空串停止
                break;
            $temp[$j]="";//初始化
            for($i=0;$i<100;$i++){
                if(array_keys($classes[$j])[$i]==null)//遍历到空串停止
                    break;
                $temp[$j][$i] = array_keys($classes[$j])[$i]; //将班级编号赋值
            }
        }
//        dump($temp);
//        for($k=0,$j=$data1[$k]['courseid'];$j<1000,$k<1000;$j++,$k++) {//将数组的编号跟课程编号同步,方便对比时的提取
//            if($data1[$k]['courseid']==null)
//                break;
//            $temp[$j]=$temp[$k];
//            unset($temp[$k]);//直接删除原来的数组
//        }
//        dump($temp);//得到每一门课程的开课班级编号,然后用用来跟学生信息对比即可出可选班级
        for($j=0;$j<200;$j++){//$stu_info[0]['classid'] 这就是学生的班级号
            if($temp[$j]==null)
                continue;//由于从0开始遍历，用来过滤没有被赋值的数组
            for($k=0;$k<31;$k++){//班级总数量少于30,采用粗暴的遍历判断
                if($temp[$j][$k]==$stu_info[0]['classid']){
                    $flag[$j]=$j;//只要相同,说明这门课可以选,记录课程编号,待会要用来遍历输出
                }
            }
        }
//        dump($flag);//该学生可选的课程编号
        for($k=0;$k<200;$k++){//检查可选
            if($flag[$k]==null||$data2[$k]['courseid']==$data1[$k]['courseid'])
                unset($data1[$k]);//直接删除原来的数组,待会显示到模版就不显示
        }
        for($k=0;$k<200;$k++){//检查已选
            if($data2[$k]==null)
                break;
            for($i=0;$i<200;$i++){
                if($data2[$k]['courseid']==$data1[$i]['courseid']){
                    unset($data1[$i]);//直接删除原来的数组,待会显示到模版就不显示
                    break;
                }
            }
        }
//        dump($k);
//        dump($i);
//        dump($data2);
//        dump($data1);
        $this->assign('data1',$data1);//显示到模板
        $this->display();
    }

    public function select_course($select = null,$cencel = null,$courseId = null){
        $this->logincheck();
        $select_course = M("student_score");
        $data['no']=session('no');
        $data['courseId']=$courseId;
        $data['score']=0;
        $data['other_score']=0;
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
