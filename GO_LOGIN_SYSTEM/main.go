package main

import (
    "bufio"
    "fmt"
    "os"
    "strings"
    "time"
)

type User struct {
	Username  string
	Password  string
	Role 	  string
	CreatedAt time.Time
}

var users = map[string]User{
    "admin": {Username: "admin", Password: "admin", Role: "admin", CreatedAt: time.Now()},
    "test":  {Username: "test", Password: "test", Role: "musteri", CreatedAt: time.Now()},
}

func login(username, password string) (bool, string) {
    user, exists := users[username]
    if !exists || user.Password != password {
        logAction(username, "Başarısız giriş")
        return false, ""
    }
    logAction(username, "Başarılı giriş")
    return true, user.Role
}

func logAction(username, action string) {
    file, err := os.OpenFile("log.txt", os.O_APPEND|os.O_CREATE|os.O_WRONLY, 0644)
    if err != nil {
        return
    }
    defer file.Close()

    log := fmt.Sprintf("%s - %s: %s\n", time.Now().Format("2006-01-02 15:04:05"), username, action)
    file.WriteString(log)
}

func createUsersFile() {
    if _, err := os.Stat("users.txt"); os.IsNotExist(err) {
        if err := saveUsers(); err != nil {
            return
        }
    }
    loadUsers()
}

func loadUsers() {
    file, err := os.Open("users.txt")
    if err != nil {
        return
    }
    defer file.Close()

    scanner := bufio.NewScanner(file)
    for scanner.Scan() {
        line := scanner.Text()
        parts := strings.Split(line, ",")
        if len(parts) != 4 {
            continue
        }
        username, password, role := parts[0], parts[1], parts[2]
        createdAt, _ := time.Parse("2006-01-02 15:04:05", parts[3])
        users[username] = User{Username: username, Password: password, Role: role, CreatedAt: createdAt}
    }
}

func saveUsers() error {
    file, err := os.Create("users.txt")
    if err != nil {
        return fmt.Errorf("user.txt oluşturulamadı: %w", err)
    }
    defer file.Close()

    for _, user := range users {
        line := fmt.Sprintf("%s,%s,%s,%s\n", user.Username, user.Password, user.Role, user.CreatedAt.Format("2006-01-02 15:04:05"))
        if _, err := file.WriteString(line); err != nil {
            return fmt.Errorf("Dosyaya yazma hatası: %w", err)
        }
    }
    return nil
}

func adminEvent() {
    scanner := bufio.NewScanner(os.Stdin)
    for {
        fmt.Println("Admin Yetkileri:")
        fmt.Println("1. Müşteri Ekle")
        fmt.Println("2. Müşteri Sil")
        fmt.Println("3. Logları Görüntüle")
        fmt.Println("4. Çıkış")
        fmt.Print("Seçiminiz: ")

        scanner.Scan()
        choice := scanner.Text()

        switch choice {
        case "1":
            addCustomer()
        case "2":
            deleteCustomer()
        case "3":
            showLogs()
        case "4":
            fmt.Println("Admin hesabından çıkış yapıldı.")
            return
        default:
            fmt.Println("Geçersiz seçim.")
        }
    }
}

func addCustomer() {
    var username, password string
    fmt.Print("Yeni müşteri adı: ")
    fmt.Scanln(&username)
    fmt.Print("Yeni müşteri şifresi: ")
    fmt.Scanln(&password)

    users[username] = User{Username: username, Password: password, Role: "musteri", CreatedAt: time.Now()}
    logAction("admin", "Yeni müşteri eklendi: "+username)

    if err := saveUsers(); err != nil {
        fmt.Println("user.txt dosyasına yazarken hata oluştu:", err)
        return
    }

    fmt.Println("Müşteri başarıyla eklendi.")
}

func deleteCustomer() {
    var username string
    fmt.Print("Silinecek müşteri adı: ")
    fmt.Scanln(&username)

    if _, exists := users[username]; exists {
        delete(users, username)
        logAction("admin", "Müşteri silindi: "+username)
        saveUsers()
        fmt.Println("Müşteri başarıyla silindi.")
    } else {
        fmt.Println("Müşteri bulunamadı.")
    }
}

func showLogs() {
    file, err := os.Open("log.txt")
    if err != nil {
        fmt.Println("Log dosyası açılamadı:", err)
        return
    }
    defer file.Close()

    fmt.Println("Loglar:")
    scanner := bufio.NewScanner(file)
    for scanner.Scan() {
        fmt.Println(scanner.Text())
    }
}

func customerEvent(currentUsername string) {
    scanner := bufio.NewScanner(os.Stdin)
    for {
        fmt.Println("Müşteri Yetkileri:")
        fmt.Println("1. Profil Görüntüle")
        fmt.Println("2. Şifre Değiştir")
        fmt.Println("3. Çıkış")
        fmt.Print("Seçiminiz: ")

        scanner.Scan()
        choice := scanner.Text()

        switch choice {
        case "1":
            viewProfile(currentUsername)
        case "2":
            changePassword(currentUsername)
        case "3":
            fmt.Printf("%s hesabından çıkış yapıldı.\n", currentUsername)
            return
        default:
            fmt.Println("Geçersiz seçim.")
        }
    }
}

func viewProfile(currentUsername string) {
    user, exists := users[currentUsername]
    if exists {
        fmt.Printf("Kullanıcı Adı: %s\n", user.Username)
        fmt.Printf("Kayıt Tarihi: %s\n", user.CreatedAt.Format("2006-01-02 15:04:05"))
    } else {
        fmt.Println("Kullanıcı bulunamadı.")
    }
}

func changePassword(currentUsername string) {
    var currentPassword, newPassword string
   
    fmt.Print("Mevcut şifre: ")
    fmt.Scanln(&currentPassword)
    user, exists := users[currentUsername]
    if !exists {
        fmt.Println("Kullanıcı bulunamadı.")
        return
    }
    if user.Password != currentPassword {
        fmt.Println("Mevcut şifre hatalı. Şifre değiştirilemedi.")
        return
    }
    fmt.Print("Yeni şifre: ")
    fmt.Scanln(&newPassword)
    user.Password = newPassword
    users[currentUsername] = user
    saveUsers()
    logAction(currentUsername, "Şifre değiştirildi")
    fmt.Println("Şifreniz başarıyla güncellendi.")
}

func main() {
    createUsersFile()

    scanner := bufio.NewScanner(os.Stdin)
    for {
        fmt.Println("Giriş Tipini Seçin: ")
        fmt.Println("0 - Admin")
        fmt.Println("1 - Müşteri")
        fmt.Println("2 - Çıkış")
        fmt.Print("Seçiminiz: ")
        scanner.Scan()
        choice := scanner.Text()

        if choice == "2" {
            fmt.Println("Uygulamadan çıkılıyor...")
            return
        }

        var username, password string
        if choice == "0" {
            username = "admin"
        } else if choice == "1" {
            fmt.Print("Müşteri adı: ")
            fmt.Scanln(&username)
        } else {
            fmt.Println("Geçersiz seçim.")
            continue
        }

        fmt.Print("Şifre: ")
        fmt.Scanln(&password)
        success, role := login(username, password)
        if success {
            if role == "admin" {
                adminEvent()
            } else if role == "musteri" {
                customerEvent(username)
            }
        } else {
            fmt.Println("Giriş başarısız.")
        }
        fmt.Println("Anasayfaya dönmek için bir tuşa basın...")
        scanner.Scan()
    }
}