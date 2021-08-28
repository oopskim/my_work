<?php
class getDairyData {
    private $pdo;
    //一画面に出せる最大のitem数
    private $disp_max=8;
    //pagination最大数
    private $page_max=5;
    //page > next,prev
    private $page_drct="";
    //業務、投資など
    private $page_cate="";
    private $page=0;
    public function __construct($pdo){
        $this->pdo = $pdo;
    }
    public function getItems($page, $drct, $cate){
        $this->page_drct=$drct;
        $this->page_cate=$cate;
        if($this->page_cate !== ""){
            //カテゴリを絞って検索
            $categorySort=" WHERE category='".$this->page_cate."'";
        } else {
            $categorySort="";
        }
        //ページ番号が「0」より少ないと「0」にする
        $this->page=$page < 0 ? 0 : $page;
        $limitStart = $this->page * $this->disp_max >= $this->getPaginationData() ? ($this->page - 1) * $this->disp_max : $this->page * $this->disp_max;
        $limit="limit ".$limitStart.", ".$this->disp_max;

        $sql="SELECT id,category,title,memo,weather,evaluate,image_name,image_content,upd_date,ins_date,
                CASE dayofweek(ins_date)
                    WHEN 1 THEN concat(DATE_FORMAT(ins_date, '%Y年%m月%d日'),'(日)')
                    WHEN 2 THEN concat(DATE_FORMAT(ins_date, '%Y年%m月%d日'),'(月)')
                    WHEN 3 THEN concat(DATE_FORMAT(ins_date, '%Y年%m月%d日'),'(火)')
                    WHEN 4 THEN concat(DATE_FORMAT(ins_date, '%Y年%m月%d日'),'(水)')
                    WHEN 5 THEN concat(DATE_FORMAT(ins_date, '%Y年%m月%d日'),'(木)')
                    WHEN 6 THEN concat(DATE_FORMAT(ins_date, '%Y年%m月%d日'),'(金)')
                    WHEN 7 THEN concat(DATE_FORMAT(ins_date, '%Y年%m月%d日'),'(土)')
                END as edited_ins_date  FROM planning_sheet.dairy".$categorySort." ORDER BY ins_date desc ".$limit;
        $stmt=$this->pdo->prepare($sql);
        $stmt->execute();
        $data=array();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $data['result']=$result;
        $data['selected_cate']=$this->page_cate;
        $data['dairy_view_flg']=$this->getViewFlg('dairy');
        $data['pagination']=$this->generatePageHtml($drct);
        return $data;
    }
    public function getViewFlg($type){
        $sql="SELECT 
                list_view
            FROM
                planning_sheet.setting
            WHERE
                type = :type";
        $stmt=$this->pdo->prepare($sql);
        $stmt->bindParam( ':type', $type);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC)['list_view'];
        return $row;
    }
    public function getPaginationData(){
        $where="";
        if($this->page_cate!==""){
            $where="WHERE category='".$this->page_cate."'";
        }
        $sql="SELECT 
                COUNT(id) as cnt
            FROM
                planning_sheet.dairy ".$where;
        $stmt=$this->pdo->prepare($sql);
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
        return $result;
    }
    /**
     * paginationを作成する、tagを作成
     */
    public function generatePageHtml($drct){
        //全体データ件数
        $total_data_cnt=$this->getPaginationData();
        $pageCnt= ceil($total_data_cnt/$this->disp_max);
        if($this->page < 0){
            $this->page=0;
        }
        $waru=floor($this->page/$this->page_max);
        $page_start=$this->page_max * $waru;
        $page_end=$page_start+$this->page_max;

        //ページの終わりがページ全体数以上の場合、最後のページは
        if($page_end>=$pageCnt){
            $page_end=$pageCnt;
        }
        //全データ件数まできて「NEXT」を押した場合
        if($page_start==$pageCnt){
            $page_start=$page_start-$this->page_max;
        }
        if($page_start<0){
            $page_start=0;
        }
        $html="<a href='index.php?md=dairy&page=".($page_start-1)."&drct=prev'>prev</a>";
        for($i=$page_start;$i<$page_end;$i++){
            if($this->page==$i){
                $styleHtml="style='background-color:#f8c8ea'";
            //next押下時のpagination css 制御
            } else if($this->page==($i+1) && $this->page_drct==="next"){
                $styleHtml="style='background-color:#f8c8ea'";
            //next, prevを除くpaginationのcss
            } else {
                $styleHtml="";
            }
            $html.="<a href='index.php?md=dairy&page=".$i."' ".$styleHtml.">".($i+1)."</a>";
        }
        $html.="<a href='index.php?md=dairy&page=".$page_end."&drct=next'>next</a>";
        if($total_data_cnt==="0"){
            return null;
        } else {
            return $html;
        }
    }
}
?>