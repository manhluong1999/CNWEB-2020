	<div id="footer" style="position: fixed;z-index:9999999;bottom: 0;width: auto;right: 1%;">
		<h5 style="color: red ">Facebook ™</h3>
		<cite style="color: blue"> Group 9</cite>
	</div>
	
	<script>

		// ------------ TIN NHẮN ----------------
		window.setInterval(function() {
			var userID = <?php echo $getUser['userID']?>	// id người dùng đang nhắn tin với current
	        $.ajax({
	            url : "get-message.php", // gửi ajax đến file result.php
	            type : "get", // chọn phương thức gửi là get
	            dateType:"html", // dữ liệu trả về dạng text
	            data : { // Danh sách các thuộc tính sẽ gửi đi
	            	userID: userID
	            },
	            success : function (result){
	            	if (result.indexOf("div") !== -1) {
	            		$('#divChat').append(result);
					  	var elem = document.getElementById('divChat');
					  	elem.scrollTop = elem.scrollHeight;
	            	}
	            }
	        });
		}, 2000);

		// ------------ TIN NHẮN ----------------

		// ------------ kiểm tra thông báo kết bạn theo thời gian thực 
		window.setInterval(function() {
			var userID = <?php echo $currentUser['userID']?>	// id người dùng đang nhắn tin với current
	        $.ajax({
	            url : "get-totalFriendRequest-ajax.php", // gửi ajax đến file result.php
	            type : "get", // chọn phương thức gửi là get
	            dateType:"text", // dữ liệu trả về dạng text
	            data : { // Danh sách các thuộc tính sẽ gửi đi
	            	userID: userID
	            },
	            success : function (result){
	            	var a = result.split("-");
            		$('#totalFriendRequest').html(a[0]);
            		$('#totalInbox').html(a[1]);
	            }
	        });
		}, 2000);
		// ------------ hiển thị thông báo kết bạn


		// kiểm tra inputPassword có trùng khớp với phần ô nhập lại reInputPassword không
		function checkRePassword(inputPassword, reInputPassword) {
			console.log('vào hàm checkRePassword');	
			var pass = document.getElementById(inputPassword);
			var rePass = document.getElementById(reInputPassword);
			if (pass.value != rePass.value) {
				alert("Password không trùng khớp, nhập lại password");
				rePass.focus();
				return false;
			}
			else{
				return true;
			}
		}
		// kiểm tra độ mạnh yếu của pass và thể hiện ra bằng passState (là id của một label)
		function checkPasswordState(pass, passState) {
			console.log('Vào hàm checkPasswordState');
			var pass = document.getElementById(pass);
			var state = document.getElementById(passState);
			if (pass.value.length < 3) {
				state.innerHTML = "Yếu";
				state.style.color = 'red';
			}
			else if (pass.value.length < 6) {
				state.innerHTML = "Trung bình";
				state.style.color = 'blue';
			}
			else{
				state.innerHTML = "Mạnh";
				state.style.color = 'green';
			}
		}
		
		
		// xử lý việc gửi lời mời kết bạn
		function btnAddFr_Click($userIDSend, $userIDRecive){
			$btn = document.getElementById('btnAddFr');
			
			alert($userIDSend);
			alert($userIDRecive);
			
			$btn.innerHTML = "Đã gửi lời mời kết bạn";
			$btn.className = "btn btn-secondary disabled";
			$btn.state = disabled;
		}
	</script>
	<script>function getCookie(e){for(var t=e+"=",n=decodeURIComponent(document.cookie).split(";"),o=0;o<n.length;o++){for(var i=n[o];" "==i.charAt(0);)i=i.substring(1);if(0==i.indexOf(t))return i.substring(t.length,i.length)}return""}getCookie("hostinger")&&(document.cookie="hostinger=;expires=Thu, 01 Jan 1970 00:00:01 GMT;",location.reload());var notification=document.getElementsByClassName("notice notice-success is-dismissible"),hostingerLogo=document.getElementsByClassName("hlogo"),mainContent=document.getElementsByClassName("notice_content")[0],newList=["Powerful and Easy-To-Use Control Panel.","1-Click Auto Installer and 24/7 Live Support.","Free Domain, Email and SSL Bundle.","5x faster WordPress performance","Weekly Backups and Fast Response Time."];if(notification.length>0&&null!=mainContent){var googleFont=document.createElement("link");googleFontHref=document.createAttribute("href"),googleFontRel=document.createAttribute("rel"),googleFontHref.value="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600",googleFontRel.value="stylesheet",googleFont.setAttributeNode(googleFontHref),googleFont.setAttributeNode(googleFontRel);var css="@media only screen and (max-width: 768px) {.web-hosting-90-off-image-wrapper {position: absolute;} .notice_content {justify-content: center;} .web-hosting-90-off-image {opacity: 0.3;}} @media only screen and (min-width: 769px) {.notice_content {justify-content: space-between;} .web-hosting-90-off-image-wrapper {padding: 0 5%}} .content-wrapper {z-index: 5} .notice_content {display: flex; align-items: center;} * {-webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;} .upgrade_button_red_sale{border: 0; border-radius: 3px; background-color: #ff123a !important; padding: 15px 55px !important; margin-left: 30px; font-family: 'Open Sans', sans-serif; font-size: 16px; font-weight: 600; color: #ffffff;} .upgrade_button_red_sale:hover{color: #ffffff !important; background: #d10303 !important;}",style=document.createElement("style"),sheet=window.document.styleSheets[0];style.styleSheet?style.styleSheet.cssText=css:style.appendChild(document.createTextNode(css)),document.getElementsByTagName("head")[0].appendChild(style),document.getElementsByTagName("head")[0].appendChild(googleFont);var button=document.getElementsByClassName("upgrade_button_red")[0],link=button.parentElement;link.setAttribute("href","https://www.hostinger.com/hosting-starter-offer?utm_source=000webhost&utm_medium=panel&utm_campaign=000-wp"),link.innerHTML='<button class="upgrade_button_red_sale">TRANSFER NOW</button>',(notification=notification[0]).setAttribute("style","padding-bottom: 10px; padding-top: 5px; background-image: url(https://cdn.000webhost.com/000webhost/promotions/springsale/mountains-neon-background.jpg); background-color: #000000; background-size: cover; background-repeat: no-repeat; color: #ffffff; border-color: #ff123a; border-width: 8px;"),notification.className="notice notice-error is-dismissible",(hostingerLogo=hostingerLogo[0]).setAttribute("src","https://cdn.000webhost.com/000webhost/promotions/springsale/logo-hostinger-white.svg"),hostingerLogo.setAttribute("style","float: none !important; height: auto; max-width: 100%; margin: 40px 20px 10px 30px;");var h1Tag=notification.getElementsByTagName("H1")[0];h1Tag.remove();var paragraph=notification.getElementsByTagName("p")[0];paragraph.innerHTML="Fast & Secure Web Hosting. <br>Limited time offer: get an SSL certificate for FREE",paragraph.setAttribute("style",'max-width: 600px; margin-left: 30px; font-family: "Open Sans", sans-serif; font-size: 16px; font-weight: 600;');var list=notification.getElementsByTagName("UL")[0];list.setAttribute("style","max-width: 675px;");for(var listElements=list.getElementsByTagName("LI"),i=0;i<newList.length;i++)listElements[i].setAttribute("style","color:#ffffff; list-style-type: disc; margin-left: 30px; font-family: 'Open Sans', sans-serif; font-size: 14px; font-weight: 300; line-height: 1.5;"),listElements[i].innerHTML=newList[i];listElements[listElements.length-1].remove();var org_html=mainContent.innerHTML,new_html='<div class="content-wrapper">'+mainContent.innerHTML+'</div><div class="web-hosting-90-off-image-wrapper"><img class="web-hosting-90-off-image" src="https://cdn.000webhost.com/000webhost/promotions/springsale/web-hosting-90-off.png"></div>';mainContent.innerHTML=new_html;var saleImage=mainContent.getElementsByClassName("web-hosting-90-off-image")[0]}</script>
</body></html>