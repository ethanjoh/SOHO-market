      <form method="post" name="mail" action="inc/sendmail_each_ok.php" enctype="multipart/form-data">
        <table summary="send mail">
          <caption>
          개별 메일 발송
          </caption>
          <tbody>
            <tr>
              <th scope="col" class="column1">보내는 사람</th>
              <td class="member"><input type='text' size='20' name="sender" value="블루버드 관리자">              </td>
            </tr>
            <tr>
              <th scope="col"  class="column1">보내는 이메일
                </td>
              <td class="member"><input type='text' size='20' name="sender_email" value="ethan.joh@gmail.com">              </td>
            </tr>
            <tr>
              <th scope="col"  class="column1">받는 사람</th>
              <td class="member"><?php
					echo "<select name='receiver_email'>\n";
					
					$mqry = "SELECT * FROM supplier
								   ORDER BY id DESC ";
					$mres = mysqli_query($connect, $mqry);
					
					for($i=0; $mrow = mysqli_fetch_array($mres); $i++) {
						echo "<option value=$mrow[md_email]>$mrow[id]($mrow[company_name])</option>\n";
					}
    			  ?> </td>
            </tr>
            <!--
            <tr>
              <th scope="col"  class="column1">받는 사람 이메일 </th>
              <td class="member"><input type='text' size='20' name="receiver_email">              </td>
            </tr>
            -->
            <tr>
              <th scope="col" class="column1">메일 제목 </th>
              <td class="member"><input type='text' size='60' name="subject" >              </td>
            </tr>
            <tr>
              <th scope="col" class="column1">첨부 파일</th>
              <td class="member"><input type='file' size='40' name="upfile">              </td>
            </tr>
            <tr>
              <th scope="col" class="column1">발송 내용
                </td>
              <td class="member"><textarea name="contents" cols="60" rows="8" ></textarea>              </td>
            </tr>
          </tbody>
        </table>
        <table summary="buttons">
          <tbody>
            <tr bgcolor='#FFFFFF'>
              <td align='right'><div class="clear"><a class="button" href="javascript:document.mail.submit()" onclick="this.blur();"><span>메일 보내기</span></a><a class="button" href="javascript:document.mail.reset();" onclick="this.blur();"><span>다시 작성</span></a></div></td>
            </tr>
          </tbody>
        </table>
      </form>
