<?php
namespace Admin\Controller;
use Org\Util\ArrayList;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $username = $this->logincheck();
        $this->assign('list', 'index');
        $this->assign('name', session('name'));
        $scores = M();
        //最高管理员可以管理其他老师的课程
        $admininfo = M("admin");
        $admindata = $admininfo -> where("username='%s'", $username) -> find();
        if($admindata['root'] == 1) {
            $sql = "select c.*,a.name
            from think_admin a ,think_course c
            where a.name = c.adminId";
        }
        else{
            $sql = "select c.*,a.name
            from think_admin a ,think_course c
            where a.name = c.adminId and '".$username."'=a.username";
        }
//        dump($username);
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
    }//主页
    public function test_ajax($q=null){
        $response = session('response');
        dump($response);
        echo $response;
//        echo "<p hidden value='"+$response+"'></p>";
//        echo "<span id='233'>23323</span>";
    }//测试ajax
    public function test(){
        $this->display();
    }//php实验空间
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
    }//检查是否登录
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
    }//登录
    public function loginout(){
        session('username', null);
        session('password', null);
        session('name', null);
        $this->success('注销成功', U('login'));
    }//注销
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

    }//修改密码
    /******************添加课程********************/
    //尚未检测主键是否会重复
    public function testInsertCourse($course = null,$teacher = null,$time = null,$endingtime = null,$people = null,$classes = null){
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
        $data['endingTime'] = $endingtime;
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
        }
        elseif($swtich == "录入成绩"){
            $this->test_table($courseId);
            exit();
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
    }//显示管理员页面
    public function addadmin($name=null,$username=null,$password=null){
        $this->logincheck();
        $InsertAdmin = M("admin");
        $data['name'] = $name;
        $data['username'] = $username;
        $data['password'] = $password;
        $data['root'] = 0;
        if($data['username']!=null){
            $InsertAdmin->add($data);
            $this -> success("添加成功!", "adminadmin");
        }

    }//添加管理员
    public function deladmin($cencel = null,$id = null){
        $this->logincheck();
        $del = M('admin');
        if($cencel == "删除"){
            $data = $del ->where("id='%s'",$id) ->delete(); // 成功返回1 失败返回0
        }
        if($data==1)
            $this -> success("删除成功!", "adminadmin");
    }//删除管理员
    public function course_stu_list($courseId = null){

        $this->logincheck();
        $this->assign('list', 'score');
        $this->assign('name', session('name'));
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
    }//选课学生列表

    public function  test_table_ajax_add($colName=null){
        $response = session('response');//将查询出来的条数从test_table函数里传回前端
        echo $response;
        if($colName){
//下面开始在other_score后面加上$colName=0并存回去,成绩比例也要这样做
            $scores_back = M("student_score");
            $courseId = session('courseidToDel');
            $data2 = $scores_back->where("courseId='%s'",$courseId)->select();
            $colName=$colName."";
            $addArray = Array($colName=>"0#0");
//            dump($addArray);
            for($j=0;$j<$response;$j++) {//注意这里仅仅是100,没有查表,反正可以自己break，尽量调大就好！！！
                if ($data2[$j]['id'] == null)//遍历到空串停止
                    break;
                $arr = json_decode($data2[$j]['other_score'], true);
//                dump($arr);
                $arr = $arr+$addArray;
//                dump($addArray);
                $arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
//                dump($arr);
                $data2[$j]['other_score'] = $arr;
                $scores_back->where("courseId='%s' and id='%s'", $courseId, $data2[$j]['id'])->setField("other_score", $data2[$j]['other_score']);
            }
        }
    }//表格内所有学生添加一个成绩类别
    public function  test_table_ajax_del($scorename=null){
        //查询数据库,根据将传进来的$scorename,删除other_score中带有$scorename的一组即可
        if($scorename){
            $scorename = (string)$scorename;
            $courseId = session('courseidToDel');//$courseId共享
            $scores_back = M("student_score");
            $data2 = $scores_back->where("courseId='%s'",$courseId)->select();
//            dump($data2);
            for($j=0;$j<100;$j++){
                //注意这里仅仅是100,没有查表,反正可以自己break，尽量调大就好！！！
                if ($data2[$j]['id'] == null)//遍历到空串停止
                    break;
                $stu_id[$j] = $data2[$j]['id'];
                $arr = json_decode($data2[$j]['other_score'], true);
                $arr2 = json_decode($data2[$j]['score_proportion'], true);
                $delArr2 = 1;//用来记录删除哪条
                foreach ($arr as $k => $v) {
                    //删除数组中特定的一行
//                    while(1){
//                        if($arr2[$delArr2]==null){
//                            $delArr2++;
//                        }
//                        else{
//                            break;
//                        }
//                    }
                    if ($k == $scorename) {
                        unset($arr[$k]);
                        unset($arr2[$delArr2]);
                        break;
                    }
//                    $delArr2++;
                }
                $arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
//                $arr2 = json_encode($arr2, JSON_UNESCAPED_UNICODE);
                $data2[$j]['other_score'] = $arr;
//                $data2[$j]['score_proportion'] = $arr2;
                $scores_back->where("courseId='%s' and id='%s'", $courseId, $stu_id[$j])->setField("other_score", $data2[$j]['other_score']);
//                $scores_back->where("courseId='%s' and id='%s'", $courseId, $stu_id[$j])->setField("score_proportion", $data2[$j]['score_proportion']);
            }
//            dump(sizeof(json_decode($data2[$j-1]['other_score'], true)));
            echo "success";
        } else echo "fail";
    }//删除表格内所有学生的一个成绩类别

    public function test_table($courseId = null){
        $this->logincheck();
        session('courseidToDel', $courseId);
        $this->assign('name', session('name'));
        $this->assign('list', 'score');
        $this->assign('username', session('username'));
        $scores = M();
        $sql = "select c.courseName,a.no,b.name,b.sex,a.score,a.other_score
                from think_student_score a ,think_stuinfo b,think_course c
                where a.courseId = c.courseId and a.no=b.no and '".$courseId."'=a.courseId";
        $data = $scores->query($sql);//查询当前登录学生所选的课程
        session('response', sizeof($data));//放入session缓存中
//        dump($data);
        for($j=0;$j<100;$j++){
            if($data[$j]['sex'] == null)break;
            elseif($data[$j]['sex'] == 0)$data[$j]['sex'] = "女";
            elseif($data[$j]['sex'] == 1) $data[$j]['sex'] = "男";
        }
//        构建四样东西给前端,成绩名称,分数,删除按钮,成绩比例
        //首先是构建成绩名称和分数
        $scoreAndProportion = array();//成绩和比例
        $scoreName_front = array();
        for($j=0;$j<100;$j++){//注意这里仅仅是100,没有查表,反正可以自己break，尽量调大就好！！！
            if(array_values(json_decode($data[$j]['other_score'], true))==null)//遍历到空串停止
                break;
            $scoreName_front[$j] = json_decode($data[$j]['other_score'],true);
            $scoreName[$j] = array_values(json_decode($data[$j]['other_score'], true));//把json数据解析为array格式
            $scoreAndProportion = array_merge($scoreAndProportion, array_values($scoreName[$j]));//把二维变一维
            $score_proportion[$j] = json_decode($data[$j]['score_proportion'],true);//把json数据解析为array格式
        }
//        dump(explode('#',$scoreAndProportion[0]));
//        dump($scoreAndProportion);//把这个拆分成成绩和比例就可以了
        for($j=0;$j<100;$j++){
            if($scoreAndProportion[$j]==null){
                break;
            }
            $scoreAndProportion[$j] = explode('#',$scoreAndProportion[$j]);
        }
        $html1 = sizeof($scoreName_front[0]);//嵌入php专用迭代器,每人有n条成绩\
        $html2 = sizeof($data);//嵌入php专用迭代器,有n个学生
        session('html1', $html1);
        session('html2', $html2);
        session('score_score', $scoreAndProportion);//输出所有人的其他成绩
        $php_html=0;//初始化迭代器
        session('php_html', $php_html);
        $php_html2=1;
        session('php_html2', $php_html2);

        for($j=0;$j<$html1;$j++) {
            $scoreAndProportion2[$j] = $scoreAndProportion[$j];//取前n(n=成绩种数)条即可
        }
        $this->assign('scoreAndProportion2',$scoreAndProportion2);//输出成绩比例

        $this->assign('data',$data);//显示总成绩以及其他数据
        $this->assign('scoreName',$scoreName_front[0]);//打印此数组的key即可打印成绩名称
        $this->display(test_table);
    }//将该课程的学生成绩信息输出到视图

    public function getAllScore($AllScore = null,$AllKindsOfScore = null){
        $scoreSum = M("student_score");
        $data = $scoreSum->where("courseid='%s'", session('courseidToDel'))->select();
        $AllScore = json_decode($AllScore);
        $AllKindsOfScore = json_decode($AllKindsOfScore,true);
        for($i=0;$i<session('response');$i++)
        {
            $otherScore[$i] = json_decode($data[$i]['other_score'], true);//不写true会错误
        }
        //先提取每种成绩的占比,然后修改所有学生的xx#占比
//        dump($AllKindsOfScore);
        $temp = Array();
        for($i=0;$i<100;$i++)
        {
            if($AllKindsOfScore[$i] == null)break;//成绩种类数量未知
            for($j=0;$j<2;$j++)//只需要读取前面两个,分别包含成绩名称和成绩占比
            {
                if($j==0) $temp[$AllKindsOfScore[$i][$j]] = 0;//将数组的key定义为成绩名称
                else $temp[$AllKindsOfScore[$i][$j-1]] = $AllKindsOfScore[$i][$j];//将数组的value定义为成绩比例
            }
        }//提取成绩比例和对应的成绩名称作为一个数组temp
//        dump($temp);
        for($i=0;$i<session('response');$i++)//已知当前选课的同学数量
        {
            for($j=0;$j<sizeof($temp);$j++)//已知成绩比例种类数
            {
                $TEMP = explode('#' , $otherScore[$i][array_keys($temp)[$j]]);
                $TEMP[1] = $temp[array_keys($temp)[$j]];//改比例
                $otherScore[$i][array_keys($temp)[$j]] = $TEMP[0]."#".$TEMP[1];
            }
        }//将 otherscore 里的 成绩比例 拆出来修改,此循环修改n位同学的信息

//        dump($otherScore);//成功改变otherscore中的 成绩比例
        //下面修改otherscore除了成绩比例外的所有信息
//        dump($otherScore);
        for($i=0;$i<100;$i++)
        {
            if($AllKindsOfScore[$i] == null)break;
                //适应数组的数据结构:0是成绩名称,1是成绩比例,2以及之后的是某同学的该成绩
                //以上两个循环为了读取$AllKindsOfScore数据
                for($k=0;$k<session('response');$k++)//已知当前选课的同学数量
                {
//                    dump($otherScore[$k][$AllKindsOfScore[$i][0]]);
                    $TEMP = explode('#' , $otherScore[$k][$AllKindsOfScore[$i][0]]);
                    $TEMP[0] = $AllKindsOfScore[$i][$k+2];//改成绩
                    $otherScore[$k][$AllKindsOfScore[$i][0]] = $TEMP[0]."#".$TEMP[1];
                }
        }
//        dump($otherScore);
//        dump($AllScore);

        for($i=0;$i<100;$i++)
        {
            if($data[$i]['score'] == null) break;
            $data[$i]['score'] = $AllScore[$i];//总成绩
        }
//        dump($data);

        for($j=0;$j<session('response');$j++)
        {
            if($data[$j]['other_score'] == null) break;
            $data[$j]['other_score'] = json_encode($otherScore[$j],JSON_UNESCAPED_UNICODE);
        }
//        dump($data);
        for($j=0;$j<session('response');$j++)
        {
            $scoreSum->where("id='%s'", $data[$j]['id'])->setField("other_score", $data[$j]['other_score']);
            $scoreSum->where("id='%s'", $data[$j]['id'])->setField("score", $data[$j]['score']);
        }

        $response = "总成绩已保存";
        echo $response;
    }//ajax获得总成绩并存到数据库

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
