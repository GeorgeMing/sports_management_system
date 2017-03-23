<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller
{
    /**************以下是系统操作*****************/
    public function index()//主界面
    {
        $this->logincheck();
        $this->assign('stuName', session('stuName'));//右上角显示用户名
        $class_info = M("stuinfo");
        $data1 = $class_info->select();
//        dump($data1);
        for($i=0;$i<100;$i++){
            if($data1[$i]['no'] == session('username')){
                if (strlen($data1[$i]['classid']) == 2) {
                    $temp_grade = (int)substr($data1[$i]['classid'], 0, 1);
                    $temp_class = substr($data1[$i]['classid'], 1, 1);
                } elseif (strlen($data1[$i]['classid']) == 3) {
                    $temp_grade = (int)substr($data1[$i]['classid'], 0, 1);
                    $temp_class = substr($data1[$i]['classid'], 1, 2);
                }
            }

        }

        $class_grade = "高".$temp_grade."(".$temp_class.")"."班";
        $this->assign('class_grade', $class_grade);
        $this->display();
//        SELECT grade,classNo
//FROM think_class ,think_stuinfo
//WHERE classId=id AND id=7
    }

    public function logincheck()//登录检查
    {
        $data = null;
        $stuinfo = M("stuinfo");
        $no = session('username');
        $password = session('password');
        $data = $stuinfo->select();

        if((int)date('m',time())==9&&$data[0]['semester']==2){//检测到仍处于第二学期,九月份提升一次年级
            for($i=0;$i<100;$i++){
                $data[$i]['semester']=1;//进入下一年的第一学期
                if(strlen($data[$i]['classid'])==2){
                    $temp_grade =(int)substr($data[$i]['classid'], 0,1);
                    if($temp_grade==3) $temp_grade=(int)date('y',time());//毕业的学生就记录毕业的年份
                    else $temp_grade++;
//                    dump($temp_grade);
                    $temp_class =substr($data[$i]['classid'], 1,1);
                    $data[$i]['classId'] = (String)$temp_grade."".$temp_class;
//                    dump($data_update['classId']);
                    $stuinfo->where("no='%s'", $data[$i]['no'])->save($data[$i]);
                }
                elseif(strlen($data[$i]['classid'])==3){
                    $temp_grade =(int)substr($data[$i]['classid'], 0,1);
                    $temp_grade++;
                    $temp_class =substr($data[$i]['classid'], 1,2);
                    $data[$i]['classid'] = (String)$temp_grade."".$temp_class;
                }
            }
        }
        if((int)date('m',time())==2&&$data[0]['semester']==1){//如果二月份还在第一学期,则提升一次学期
            for($i=0;$i<100;$i++){
                $data[$i]['semester']=2;//进入第二学期
                $stuinfo->where("no='%s'", $data[$i]['no'])->save($data[$i]);
            }
        }

        $studata = $stuinfo->where("no='%s'", $no)->find();
        if ($studata) {
            if ($studata['no'] == $no && $studata['password'] == $password) {
                return $no;
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
                    session('username', $no);
                    session('password', $password);
                    session('stuName', $studata['name']);
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
        session('stuName', null);
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
            $no = session("username");
            $password = $stuinfo->where("no='%s'", $no)->getField("password");
//            dump($password);
            if ($password == $oldpassword) {
                $stuinfo->where("no='%s'", $no)->setField("password", $newpassword);
                session("password", $newpassword);
                $this->success("修改密码成功", U('index'));
            } else {
                dump($oldpassword);

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
            if((int)date('m',time()) > 9){
                $data['semester'] = 1;
            }else{
                $data['semester'] = 2;
            }
//            echo $no."".$name."".$password."".$sex."".$grade."".$classes;
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
        $this->assign('stuName', session('stuName'));//右上角显示用户名
        $class_info = M("stuinfo");
        $data1 = $class_info->select();
//        dump($data1);
        for($i=0;$i<100;$i++){
            if($data1[$i]['no'] == session('username')){
                if (strlen($data1[$i]['classid']) == 2) {
                    $temp_grade = (int)substr($data1[$i]['classid'], 0, 1);
                    $temp_class = substr($data1[$i]['classid'], 1, 1);
                } elseif (strlen($data1[$i]['classid']) == 3) {
                    $temp_grade = (int)substr($data1[$i]['classid'], 0, 1);
                    $temp_class = substr($data1[$i]['classid'], 1, 2);
                }
            }
        }//显示班级

        $class_grade = "高".$temp_grade."(".$temp_class.")"."班";
        $this->assign('class_grade', $class_grade);


        $no = session('username');
//        dump($no);
        $show2 = M();
        $sql = "select a.courseName,a.adminId,a.courseId from think_course a,think_student_score b where a.courseId = b.courseId and b.no='".$no."'";
        $data2 = $show2->query($sql);//查询当前登录学生所选的课程
        $this->assign('data2',$data2);
//        dump($data2);
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

        $this->assign('data1',$data1);//显示到模板
        $this->display();
    }

    public function select_course($select = null,$cencel = null,$courseId = null){
        $this->logincheck();
        $this->assign('name', session('stuName'));

        $semeter_search = M("stuinfo");//需要查询stuinfo
        $data_semeter = $semeter_search->where("name='%s'", session('stuName'))->select();
        $select_course = M("student_score");//需要插入改动student_score
        $data['no']=session('username');
        $data['courseId']=$courseId;
        $data['score']=0;
        $data['other_score']=0;
        $data['semester']=$data_semeter[0]['semester'];
        $data['score_proportion'] = 0;
        $change_choicenumber = M("course");//需要更新改动course
        $data2=$change_choicenumber->where("courseId='%s'",$courseId)->select();
//        dump($data2[0]['choicenumber']);
//        dump($data2);
        if($select == "选课"){
            $select_course->add($data);//插入
            if((int)$data2[0]['choicenumber']>=(int)$data2[0]['peoplenumber']){
                $this->error("课程容量已满","course_list");
                return ;
            }
            $data2[0]['choicenumber'] = (int)$data2[0]['choicenumber']+1;
            $data2[0]['choicenumber'] = (string)$data2[0]['choicenumber'];
//            dump($data2);
            $change_choicenumber->where("courseId='%s'",$courseId)->setField("choiceNumber", $data2[0]['choicenumber']);
            $this -> success("选课成功!", "course_list");
        }
        elseif($cencel == "取消"){
            $select_course ->where("courseid='%s' and no='%s'",$courseId,$data['no']) ->delete();//删除
            $data2[0]['choicenumber'] = (int)$data2[0]['choicenumber']-1;
            $data2[0]['choicenumber'] = (string)$data2[0]['choicenumber'];
//            dump($data2);
            $change_choicenumber->where("courseId='%s'",$courseId)->setField("choiceNumber", $data2[0]['choicenumber']);
            $this -> success("取消选课!", "course_list");
        }
    }
    public function test(){
        echo date('m',time());
    }

}
