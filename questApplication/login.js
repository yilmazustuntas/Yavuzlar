document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('loginForm').addEventListener('submit', function(event) {
      event.preventDefault();
  
      const username = document.getElementById('username').value;
      const password = document.getElementById('password').value;
  
      console.log('Kullanıcı Adı:', username);
      console.log('Şifre:', password);
  
      if (username === 'admin' && password === 'admin') {
        window.location.href = 'admin.html';
      } else {
        alert('Hatalı kullanıcı adı veya şifre!');
      }
    });
  
    window.goToHomePage = function() {
      window.location.href = 'index.html';
    };
  });
  