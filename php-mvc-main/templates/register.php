<h2>สมัครสมาชิก</h2>

<form method="POST" action="/register">

    ชื่อ:<br>
    <input type="text" name="name" required><br><br>

    เพศ:<br>
    <select name="gender">
        <option value="ชาย">ชาย</option>
        <option value="หญิง">หญิง</option>
        <option value="อื่นๆ">อื่นๆ</option>
    </select><br><br>

    Email:<br>
    <input type="email" name="email" required><br><br>

    วันเกิด:<br>
    <input type="date" name="birthdate"><br><br>

    อาชีพ:<br>
    <input type="text" name="occupation"><br><br>

    จังหวัด:<br>
    <input type="text" name="province"><br><br>

    รหัสผ่าน:<br>
    <input type="password" name="password" required><br><br>

    <button type="submit">สมัครสมาชิก</button>

</form>