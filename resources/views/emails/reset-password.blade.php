<table border="0" cellspacing="0" cellpadding="0" style="max-width:600px; display: block; margin: 0 auto;" >
    <tbody>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td align="left"><img width="92" height="32" src="{{ asset('images/logo.png') }}" style="display:block;width:92px;height:32px" class="CToWUd"></td>
                            <td align="right"><img width="32" height="32" style="display:block;width:32px;height:32px" src="https://ci3.googleusercontent.com/proxy/12rTzUTfWWCBJcvBcXJwQVKJIoKWWntqD08OrTXdjt7fq1-LLHD4oI_HQpgdZC1Gx7dX6vqHiGVE_VTOkZWq_yGhaViaMBlMd9o=s0-d-e1-ft#https://ssl.gstatic.com/accountalerts/email/keyhole.png" class="CToWUd"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr height="16"></tr>
        <tr>
            <td>
                <table bgcolor="#4184F3" width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width:332px;max-width:600px;border:1px solid #e0e0e0;border-bottom:0;border-top-left-radius:3px;border-top-right-radius:3px">
                    <tbody>
                        <tr>
                            <td height="72px" colspan="3"></td>
                        </tr>
                        <tr>
                            <td width="32px"></td>
                            <td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:24px;color:#ffffff;line-height:1.25">Mã xác minh Cake</td>
                            <td width="32px"></td>
                        </tr>
                        <tr>
                            <td height="18px" colspan="3"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table bgcolor="#FAFAFA" width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width:332px;max-width:600px;border:1px solid #f0f0f0;border-bottom:1px solid #c0c0c0;border-top:0;border-bottom-left-radius:3px;border-bottom-right-radius:3px">
                    <tbody>
                        <tr height="16px">
                            <td width="32px" rowspan="3"></td>
                            <td></td>
                            <td width="32px" rowspan="3"></td>
                        </tr>
                        <tr>
                            <td>
                                <p>Kính gửi {{ ucfirst($full_name) }} </p>
                                <p>Mã xác minh bạn cần dùng để truy cập vào tài khoản (<span style="color:#659cef" dir="ltr">{{ ucfirst($email) }}</span>) là:</p>
                                <div style="text-align:center">
                                    <p dir="ltr"><strong style="text-align:center;font-size:24px;font-weight:bold">{{ ucfirst($verification_code) }}</strong></p>
                                </div>
                                <p>Bạn nhận được thông báo này vì địa chỉ email này được liệt kê là email khôi phục cho tài khoản <span style="color:#659cef" dir="ltr">{{ ucfirst($email) }}</span>. </p>
                                <p> Trân trọng!</p>
                                <p>Cake!</p>
                            </td>
                        </tr>
                        <tr height="32px"></tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr height="16"></tr>
        <tr>
            <td style="max-width:600px;font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:10px;color:#bcbcbc;line-height:1.5">
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <table style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:10px;color:#666666;line-height:18px;padding-bottom:10px">
                                    <tbody>
                                        <tr>
                                            <td>Email này không thể nhận thư trả lời. Để biết thêm thông tin, hãy truy cập .<br>© Google Inc., 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
  </table>