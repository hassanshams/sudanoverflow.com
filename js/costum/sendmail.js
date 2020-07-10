<script>
$(document).ready(function(){
     function sendEmail() {
        Email.send({
            Host : "smtp.gmail.com",
            Username : "<hassanshams43@gmail.com>",
            Password : "<12345_12345>",
            To : 'hassanshams43@yahoo.com',
            From : "hassanshams43@gmail.com",
            Subject : "Test email",
            Body : "<html><h2>Header</h2><strong>Bold text</strong><br></br><em>Italic</em></html>"
        }).then(
          message => alert(message)
        );
        }
    });
</script>