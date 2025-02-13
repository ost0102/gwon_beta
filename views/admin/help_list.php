﻿<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<?$this->load->view('/include/head_info');?>
<script type='text/javascript'>
	//jQuery 있는 상태
	window.onload=function(){
        check_con_div();
		check_w_mode();
	};

	$(document).ready(function() {
		/* 

		modal창의 콘텐츠에서 클릭해도 창이 없어지지 않도록 하려면...
		 $('body').click(function(){
			check_modal();
		 });
		*/

		//html2 관련
		$doc_h = $(window).height();
		$doc_w = $(window).width();
		//alert($doc_w);
		$contents_h = $('.contents').height();
		//브라우저 너비에 따라 콘텐츠창 사이즈 조정하기
		window.ipg_scr_left_sate = 'off';

		//$('.contents').css('height',$doc_h);//감춤
		//modal 관련
		 $('#m_close').click(function(){
		  $.modal.close();
		  $modal_state ='off';
		 });
		
		 $modal_state ='off';

	});
	function check_update_page(){
		var update_page = $('#update_page').html();
		

		$.get("/openpage/admin_update_check",function(data,status){
			//alert("Data: " + data + "\nStatus: " + status);
			$('#update_page').html(data);
	   });
	}
</script>
</head>
<body>
<div id=right_top_shape>
	<a href='http://<?=$config['intro_url'];?>/page'><img src='/img/land/right_top_shape.png' class='logo_shape'></a>
</div>
<div id='container'>
	<div class='menu_left'>
		<div id=menu_area>
			<!-- sub_top area include -->
			<?$this->load->view('/include/sub_top');?>
			<!-- menu area 시작 -->
			<?$this->load->view('/include/left_menu');?>
			<!-- menu area 끝 -->
		</div>
		<div class='bt_sub'>
			
		</div>
	</div>
	</div>
	<div class='contents'>
		<!--상단영역 -->
		<?$this->load->view('/include/top_area');?>
		<!--상단영역 끝-->
		<!--콘텐츠 영역 -->
		<div id='content_area'>
			<div id='con_div'>
				<!-- Contents Area Start -->
				<div id='con_area'>
					<div id='con_main'>
						<?$this->load->view('/include/admin_menu');?>
						<div style="width: 100%; text-align: center; padding-bottom: 10px; border-bottom: 1px solid #cdcdcd; margin-bottom: 20px;">
							<a onclick="help_list(1);" >접수</a>&nbsp;|&nbsp;
							<a onclick="help_list(2);" >견적 발송</a>&nbsp;|&nbsp;
							<a onclick="help_list(3);" >진행</a>&nbsp;|&nbsp;
							<a onclick="help_list(4);" >취소</a>&nbsp;|&nbsp;
							<a onclick="help_list(5);" >기술 지원 완료</a>&nbsp;|&nbsp;
							<a onclick="help_list(6);" >견적서 발송</a>&nbsp;|&nbsp;
							<a onclick="help_list(7);" >입금 확인</a>&nbsp;|&nbsp;
							<a onclick="help_list(8);" >삭제</a>
						</div>
						<!--Help list 출력 시작 -->
						<div id="help_list_area">
							<? if(isset($help_list)){
									//print_r($linked_info);
									$first_check = 0;
									foreach ($help_list as $help_list)
									{
										//print_r($row);
										//class_no가 없을 경우 최근 값을 가져와라
										$offer_id = $help_list['offer_id'];
										$name = $help_list['name'];
										$user_id = $help_list['user_id'];
										$phone = $help_list['phone'];
										$price = $help_list['price'];
										$offer_area = $help_list['offer_area'];
										$offer_con = $help_list['offer_con'];
										$p_num = $help_list['p_num'];
										$social = $help_list['social'];
										$check_response = $help_list['check_response'];
										$check_state = $help_list['check_state'];
										$price = number_format($price);

										//p_secur가 있으면 활성화된 페이지 정보가 있는거
										if(isset($help_list['p_secur'])){
											$p_secur = $help_list['p_secur'];
											$p_title = $help_list['p_title'];
											$p_script = $help_list['p_script'];
											$p_domain = $help_list['p_domain']; 
											$project_img = $help_list['project_img']; 
											$logo = $help_list['logo']; 

											if(isset($help_list['project_img'])){
												$project_img = $help_list['project_img']; 
											}else if(isset($logo) && $logo!=''){
												$project_img = $logo;
											}else{
												$project_img = '/img/intropage_twt.jpg';
											}
										}else{
											if($offer_area !=3){
												$p_title = '신규 페이지';
												$p_script = '새로 제작될 페이지에 대한 기술 요청을 신청하셨습니다.';
												$project_img = '/img/intropage_twt.jpg';
											}else{
												$p_title = '메일 문의';
												$p_script = '메일 문의 내용입니다.';
												$project_img = '/img/intropage_twt.jpg';
											}
										}
										if($user_id == 0){
											$user_id_type ='비회원';
										}else{
											$user_id_type ='회원';
										}

										if($check_response == 'n'){
											$check_txt = '접수';
											$now_state_txt = '<b>접수</b> > 진행 > 완료';
										}else if($check_response == 'y'){
											if($check_state == 1){
												$check_txt = '견적 발행';
												$now_state_txt = '접수 > <b>진행</b> > 완료';
											}else if($check_state == 2){
												$check_txt = '기술 지원 중';
												$now_state_txt = '접수 > <b>진행</b> > 완료';
											}else if($check_state == 3){
												$check_txt = '요청 취소';
												$now_state_txt = '접수 > 진행 > <b>완료</b>';
											}else if($check_state == 4){
												$check_txt = '업무 지원 완료';
												$now_state_txt = '접수 > 진행 > <b>완료</b>';
											}else if($check_state == 5){
												$check_txt = '계산서 발행';
												$now_state_txt = '접수 > 진행 > <b>완료</b>';
											}else if($check_state == 6){
												$check_txt = '입금 확인';
												$now_state_txt = '접수 > 진행 > <b>완료</b>';
											}else if($check_state == 7){
												$check_txt = '완료';
												$now_state_txt = '접수 > 진행 > <b>완료</b>';
											}
										}

										if($offer_area == 1){
											$offer_area_txt = '기술지원 요청';
										}else if($offer_area == 2){
											$offer_area_txt = '추가 지원';
										}else if($offer_area == 3){
											$offer_area_txt = '기타';
										}else if($offer_area == 4){
											$offer_area_txt = '시리즈 맵';
										}

										echo "<div class='project_con'>";

										if($first_check!==0){
											echo "<hr style='margin-bottom:10px;'/>";
										}
										
										echo "
											<table width='100%'>
												<tr>
													<td valign='top' style='width: 110px;'>
														<div class='circular' style='background:url(".$project_img.") #cdcdcd no-repeat center center; width: 90px; height:90px; background-size:100px 100px;'></div>
													</td>
													<td valign='top'>
														<h3>".$p_title."</h3><span>".$p_script."<br/>
														<div style='float:left; margin-right: 10px;' white-space:nowrap;>요청자 : ".$name."(".$user_id_type.") /</div>
														<div style='float:left; margin-right: 10px;' white-space:nowrap;>요청 범위 : ".$offer_area_txt." /</div>
														<div style='float:left; margin-right: 10px;' white-space:nowrap;>견적 : ".$price." /</div>
														<div style='float:left; margin-right: 10px;' white-space:nowrap;> 상태 :".$check_txt."</div></span>";
														//페이지정보
														echo "<div style='float:left; width: 100%; margin-top: 10px; white-space:nowrap;'><img src='/img/icon/icon_search.png' style='margin-right: 5px; width: 15px;'/><a href='/admin/show_help_detail/".$offer_id."' target='_self'>상세보기</a>";
														"</div>";

										echo"		</td>
												</tr>
											</table>";
										echo "</div>";
										$first_check++;
									}
							}else{
								echo '요청한 내역이 없습니다.<br/> <a href="/makepage/" target="_self">intropage 생성하기</a>';
							}?>
						</div>
						<!--Help list 출력 끝 -->
						<!-- copyright area 시작 -->
						<?$this->load->view('/include/bottom');?>
						<!-- copyright area 끝 -->
					</div>
					<!-- Contents Area finish -->
				</div>
			</div>
		</div>
		<!--콘텐츠 영역 끝 -->
	</div>
</div>
<div id='modal_content'>
	 <div id='modal_txt'>
		<!--내용 출력부분 시작-->
		이곳에 내용 출력
	</div>
	<div id=login_close>
		<a onClick='modal_off()'><img src='/img/land/bt_close.png'></a>
	</div>
</div>
<!--모달창 출력부분 끝 -->
<!--modal창 관련 -->
<script type='text/javascript' src='/js/jquery.simplemodal.js'></script>
<SCRIPT TYPE="text/javascript">
	function help_list(list_type){
		var list_type = list_type;
		$('#help_list_area').html('<div style="text-align:center; padding-top: 20px;"><img src="/img/loading.gif" style="width:50px;"><br/>loading</div>');
		$.post("/admin/show_offer_list_section",{
			list_type: list_type
		},
	   function(data){
		 //alert(data);
		 $('#help_list_area').html(data);
	   }); 
		
	}
</SCRIPT>
</body>
</html>