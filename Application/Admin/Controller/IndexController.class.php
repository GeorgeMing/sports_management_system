<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $username = $this->logincheck();
        $this->assign('list', 'index');
        $this->assign('name', session('name'));
        $scores = M();
//        dump($username);
        $sql = "select c.*,a.name
                from think_admin a ,think_course c
                where a.name = c.adminId and '".$username."'=a.username";
        $data = $scores->query($sql);//查询当前登录学生所选的课程

        for($j=0;$j<100;$j++){//注意这里仅仅是100,没有查表,反正可以自己break，尽量调大就好！！！
            $classes[$j] = json_decode($data[$j]['classrangeid'], true);//把json数据解析为array格式
            if($classes[$j]==null)//遍历到空串停止
                break;

            $temp[$j]="";//初始化数组用来连接字符串
            for($i=0;$i<100;$i++){
                if(array_values($classes[$j])[$i]==null)//遍历到空串停止
                    break;
                if ($temp[$j]=="") {//找到的第一个名字
                    $temp[$j]=array_values($classes[$j])[$i];
                }
                else {//如果找到一个或多个名字，把 $hint  设置为这些名字,并用','分割开
                    $temp[$j] = $temp[$j]."，".array_values($classes[$j])[$i];//将31->高三一班,32->高三二班 变成 xxx->高三一班,高三二班 的结构
                }
            }
        }
//        dump($data);
//        dump($classes);
//        dump(json_encode($classes[0]));

        for($i=0;$i<100;$i++){
            if($temp[$i]==null)//遍历到空串停止
                break;
            $age[$i]=array("cla"=>$temp[$i]);//为了构造出与$data相同结构的数组 其实已经是3维数组了
        }
//        dump($age);
//        dump($data);
        for($i=0;$i<100;$i++) {
            if($age[$i]==null)
                break;
            $data[$i] = array_merge($age[$i], $data[$i]);//合并时，将age的23维与$data的23维合并，否则会从头开始压栈，得不到想要的输出
        }
//        dump($data);
        $this->assign('data',$data);//此时的data多了cla，其余则是从数据库里读出来的，略dt
        $this->display();
    }
    public function test_ajax($q=null){
        $response = session('response');
        dump($response);
        echo $response;
//        echo "<p hidden value='"+$response+"'></p>";
//        echo "<span id='233'>23323</span>";
    }
    public function test(){//php实验空间
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
                return $username;
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

    /******************添加课程********************/
    //尚未检测主键是否会重复
    public function testInsertCourse($course = null,$teacher = null,$time = null,$people = null,$classes = null){
        $this->logincheck();
        $InsertCourse = M("course");
        $arr=array(//定义编号和班级名称对于的json
                    "11" => "高一（1）班", "12" => "高一（2）班", "13" => "高一（3）班", "14" => "高一（4）班", "15" => "高一（5）班", "16" => "高一（6）班", "17" => "高一（7）班", "18" => "高一（8）班", "19" => "高一（9）班", "110" => "高一（10）班", "111" => "高一（11）班", "112" => "高一（12）班", "113" => "高一（13）班", "114" => "高一（14）班", "115" => "高一（15）班", "116" => "高一（16）班", "117" => "高一（17）班", "118" => "高一（18）班", "119" => "高一（19）班", "120" => "高一（20）班", "121" => "高一（21）班", "122" => "高一（22）班", "123" => "高一（23）班", "124" => "高一（24）班", "125" => "高一（25）班", "126" => "高一（26）班", "127" => "高一（27）班", "128" => "高一（28）班", "129" => "高一（29）班", "130" => "高一（30）班",
                "21" => "高二（1）班", "22" => "高二（2）班", "23" => "高二（3）班", "24" => "高二（4）班", "25" => "高二（5）班", "26" => "高二（6）班", "27" => "高二（7）班", "28" => "高二（8）班", "29" => "高二（9）班", "210" => "高二（10）班", "211" => "高二（11）班", "212" => "高二（12）班", "213" => "高二（13）班", "214" => "高二（14）班", "215" => "高二（15）班", "216" => "高二（16）班", "217" => "高二（17）班", "218" => "高二（18）班", "219" => "高二（19）班", "220" => "高二（20）班", "221" => "高二（21）班", "222" => "高二（22）班", "223" => "高二（23）班", "224" => "高二（24）班", "225" => "高二（25）班", "226" => "高二（26）班", "227" => "高二（27）班", "228" => "高二（28）班", "229" => "高二（29）班", "230" => "高二（30）班",
            "31" => "高三（1）班", "32" => "高三（2）班", "33" => "高三（3）班", "34" => "高三（4）班", "35" => "高三（5）班", "36" => "高三（6）班", "37" => "高三（7）班", "38" => "高三（8）班", "39" => "高三（9）班", "310" => "高三（10）班", "311" => "高三（11）班", "312" => "高三（12）班", "313" => "高三（13）班", "314" => "高三（14）班", "315" => "高三（15）班", "316" => "高三（16）班", "317" => "高三（17）班", "318" => "高三（18）班", "319" => "高三（19）班", "320" => "高三（20）班", "321" => "高三（21）班", "322" => "高三（22）班", "323" => "高三（23）班", "324" => "高三（24）班", "325" => "高三（25）班", "326" => "高三（26）班", "327" => "高三（27）班", "328" => "高三（28）班", "329" => "高三（29）班", "330" => "高三（30）班"
        );
        foreach( $classes as $i)
        {
            if($i){//有选中
                for($j = 0;$j<90;$j++) {//用class号在上面的数组里找到对于的班级名称
                    if (array_keys($arr)[$j] == $i) {
                        $k=array_keys($arr)[$j];//记录位置
                        break;
                    }
                }
                $classes2[$i]= $arr[$k];
            }
        }
        $jsondata = json_encode($classes2);
        $data['courseName'] = $course;
        $data['classRangeId'] = $jsondata;
        $data['adminId'] = $teacher;
        $data['time'] = $time;
        $data['peopleNumber'] = $people;
        $data['choiceNumber'] = 0;
        if($classes){
            $InsertCourse->add($data);
            $this -> success("添加成功!", "index");
        }
        else{
            $this->error("输入信息不完整或错误","index",1);
        }
    }
    /*********************删除课程*********************/
    public function delCourse($swtich = null,$courseId = null){
        $this->logincheck();
        $del = M('course');
        if($swtich == "取消课程"){
            $data = $del ->where("courseid='%s'",$courseId) ->delete(); // 成功返回1 失败返回0
        }
        elseif($swtich == "选课学生"){
            $this->course_stu_list($courseId);
            exit();
        }elseif($swtich == "录入成绩"){
            $this->redirect('test_table', array('courseId' => $courseId));
        }
//        echo $courseId;
        if($data==1)
            $this -> success("删除成功!", "index");
    }
    /********************成绩管理*********************/
    public function score(){

        $username = $this->logincheck();
        $this->assign('list', 'score');
        $this->assign('name', session('name'));

        $scores = M();
        $sql = "select c.*
                from think_admin a ,think_course c
                where a.name = c.adminId and '".$username."'=a.username";
        $data = $scores->query($sql);//查询当前登录学生所选的课程
        for($j=0;$j<100;$j++){//注意这里仅仅是100,没有查表,反正可以自己break，尽量调大就好！！！
            $classes[$j] = json_decode($data[$j]['classrangeid'], true);//把json数据解析为array格式
            if($classes[$j]==null)//遍历到空串停止
                break;
            $temp[$j]="";//初始化
            for($i=0;$i<100;$i++){
                if(array_values($classes[$j])[$i]==null)//遍历到空串停止
                    break;
                $temp[$j] = $temp[$j]."".array_values($classes[$j])[$i]."、";//将31->高三一班,32->高三二班 变成 xxx->高三一班,高三二班 的结构
            }
        }
        for($i=0;$i<100;$i++){
            if($temp[$i]==null)//遍历到空串停止
                break;
            $age[$i]=array("cla"=>$temp[$i]);//为了构造出与$data相同结构的数组 其实已经是3维数组了
        }
//        dump($age);
//        dump($data);
        for($i=0;$i<100;$i++) {
            if($age[$i]==null)
                break;
            $data[$i] = array_merge($age[$i], $data[$i]);//合并时，将age的23维与$data的23维合并，否则会从头开始压栈，得不到想要的输出
        }
//        dump($data);
        $this->assign('data',$data);//此时的data多了cla，其余则是从数据库里读出来的，略dt
        $this->display();
}
    //成绩录入
    public function addscore($courseId = null){
        $this->logincheck();
        $this->assign('list', 'score');
        $this->assign('username', session('username'));

        $scores = M();
        $sql = "select c.courseName,a.no,b.name,b.sex,a.score
                from think_student_score a ,think_stuinfo b,think_course c
                where a.courseId = c.courseId and a.no=b.no and '".$courseId."'=a.courseId";
        $data = $scores->query($sql);//查询当前登录学生所选的课程
        $this->assign('data',$data);
        $this->display();
    }
    /******************管理员管理********************/
    public function adminadmin($fileid = null, $filecomm = null){
        $i=$this->logincheck();
        if($i == "admin"){
            $this->assign('list', 'adminadmin');
            $this->assign('name', session('name'));
            $show = M("admin");
            $data = $show->select();
            $this->assign('data',$data);
            $this->display();
        }
        else{
            $this -> error("权限不足!", "index");
        }
    }
    //添加管理员
    public function addadmin($name=null,$username=null,$password=null,$root=null){
        $this->logincheck();
        $InsertAdmin = M("admin");
        $data['name'] = $name;
        $data['username'] = $username;
        $data['password'] = $password;
        $data['root'] = $root;
        if($data['username']!=null){
            $InsertAdmin->add($data);
            $this -> success("添加成功!", "adminadmin");
        }

    }
    //删除管理员
    public function deladmin($cencel = null,$id = null){
        $this->logincheck();
        $del = M('admin');
        if($cencel == "删除"){
            $data = $del ->where("id='%s'",$id) ->delete(); // 成功返回1 失败返回0
        }
        if($data==1)
            $this -> success("删除成功!", "adminadmin");
    }
    public function course_stu_list($courseId = null){

        $this->logincheck();
        $this->assign('list', 'score');
        $this->assign('username', session('username'));
        $scores = M();
        $sql = "select b.no,b.name,b.sex,b.classId
                from think_student_score a ,think_stuinfo b,think_course c
                where a.courseId = c.courseId and a.no=b.no and '".$courseId."'=a.courseId";
        $data = $scores->query($sql);//查询当前登录学生所选的课程
//        session('response', sizeof($data));//放入session缓存中
        for($i=0;$i<sizeof($data);$i++){
            if($data[$i]['sex']==1){
                $data[$i]['sex']="男";
            }
            elseif($data[$i]['sex']==0){
                $data[$i]['sex']="女";
            }
        }
//        dump($data);
        $this->assign('data',$data);
        $this->display(course_stu_list);
    }
    //文件下载
    private function fileDownload(){

    }
    //文件上传
    private function fileUpload(){

    }
    public function  test_table_ajax_add($q){
        $response = session('response');//将查询出来的条数从test_table函数里传回前端
        if($q){
            echo $response;
        }
//        $scores = M();
//        $sql = "ALTER TABLE think_student_score ADD '233' IndexControllerT(3) NOT NULL";
//        $sql = "ALTER TABLE think_student_score ADD `233` INT(3) NOT NULL";
//        $scores->execute($sql);//查询当前登录学生所选的课程
////        ALTER TABLE `think_student_score`DROP `平时成绩`;
//        dump($q);
    }
    public function  test_table_ajax_del($scorename=null){
        //查询数据库,根据将传进来的$scorename,删除other_score中带有$scorename,的一组即可
        if($scorename){
            $scorename = (string)$scorename;
            $courseId = session('courseidToDel');//$courseId共享
            $scores_back = M("student_score");
            $data2 = $scores_back->where("courseId='%s'",$courseId)->select();

            for($j=0;$j<100;$j++) {//注意这里仅仅是100,没有查表,反正可以自己break，尽量调大就好！！！
                if ($data2[$j]['id'] == null)//遍历到空串停止
                    break;
                $stu_id[$j] = $data2[$j]['id'];
                $arr = json_decode($data2[$j]['other_score'], true);
                foreach ($arr as $k => $v) {
                    //删除数组中特定的一行
                    if ($k == $scorename) {
                        unset($arr[$k]);
                    }
                }
                $arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
                $data2[$j]['other_score'] = $arr;
//        dump($data2[0]['other_score']);
                $scores_back->where("courseId='%s' and id='%s'", $courseId, $stu_id[$j])->setField("other_score", $data2[$j]['other_score']);
            }
            echo "success";
        }
        else echo "fail";
    }
    //        暂时不需要返回数据,保留待扩展
//        if($scorename){
//            echo $courseId;
//        }

//        $scores = M();
//        $sql = "ALTER TABLE think_student_score ADD '233' IndexControllerT(3) NOT NULL";
//        $sql = "ALTER TABLE think_student_score ADD `233` INT(3) NOT NULL";
//        $scores->execute($sql);//查询当前登录学生所选的课程
////        ALTER TABLE `think_student_score`DROP `平时成绩`;
//        dump($q);

    public function test_table($courseId = null){
        $this->logincheck();
        session('courseidToDel', $courseId);
        $this->assign('list', 'score');
        $this->assign('username', session('username'));
        $scores = M();
        $sql = "select c.courseName,a.no,b.name,b.sex,a.score,a.other_score,a.score_proportion
                from think_student_score a ,think_stuinfo b,think_course c
                where a.courseId = c.courseId and a.no=b.no and '".$courseId."'=a.courseId";
        $data = $scores->query($sql);//查询当前登录学生所选的课程
        session('response', sizeof($data));//放入session缓存中
//        dump($data);
//        构建四样东西给前端,成绩名称,分数,删除按钮,成绩比例
        //首先是构建成绩名称和分数
        $score_score = array();
        $score_proportion = array();
        for($j=0;$j<100;$j++){//注意这里仅仅是100,没有查表,反正可以自己break，尽量调大就好！！！
            if(array_values(json_decode($data[$j]['other_score'], true))==null)//遍历到空串停止
                break;
            $scoreName_front[$j] = json_decode($data[$j]['other_score'],true);
            $scoreName[$j] = array_values(json_decode($data[$j]['other_score'], true));//把json数据解析为array格式
            $score_score = array_merge($score_score, array_values($scoreName[$j]));//把二维变一维
            $score_proportion[$j] = json_decode($data[$j]['score_proportion'],true);//把json数据解析为array格式
        }
        session('score_score', $score_score);
        $this->assign('data',$data);
        $this->assign('score_proportion',$score_proportion[0]);
        $this->assign('scoreName',$scoreName_front[0]);//打印此数组的key即可打印成绩名称
//        dump($scoreName_front);
        $php_html=0;//初始化迭代器
        session('php_html', $php_html);
        $php_html2=1;
        session('php_html2', $php_html2);
        $this->display();
    }

    public function  test_android_get($content=null){
        echo base64_decode($content);
    }

    public function  test_android_get_registered($account=null,$password=null,$problem=null,$answer=null){//注册
        $data['account'] = base64_decode($account);
        $data['password'] = base64_decode($password);
        $data['problem'] = base64_decode($problem);
        $data['answer'] = base64_decode($answer);
        if($data['account']!=null&&$data['password']!=null&&$data['problem']!=null&&$data['answer']!=null){
            $registered = M("android_test");
            $registered->add($data);
            echo "success";
        }
        else{
            echo "fail";
        }
    }
    public function  test_android_get_login($account=null,$password=null){//登录
        $data['account'] = base64_decode($account);
        $data['password'] = base64_decode($password);
        if($data['account']!=null&&$data['password']!=null){
            $login = M("android_test");
            $result = $login -> where("account='%s'", $data['account']) -> find();
            if($result){
                if($result['account'] == $data['account'] && $result['password'] == $data['password']){
                    echo "success";
                }
                else{
                    echo "fail error";
                }
            }
            else{
                echo "result null";
            }
        }
        else{
            echo "a p fail null";
        }
    }
}
?>
