package main

import (
	"bufio"
	"fmt"
	"log"
	"os"
	"strings"
	"github.com/PuerkitoBio/goquery"
	"github.com/spf13/viper"
)

type SiteConfig struct {
	Name            string `mapstructure:"name"`
	BaseURL         string `mapstructure:"base_url"`
	ArticleSelector string `mapstructure:"article_selector"`
	TitleSelector   string `mapstructure:"title_selector"`
	DescSelector    string `mapstructure:"desc_selector"`
	DateSelector    string `mapstructure:"date_selector"`
}

type Article struct {
	Title       string
	Description string
	Date        string
}

func main() {
	viper.SetConfigName("config")
	viper.SetConfigType("yaml")
	viper.AddConfigPath(".")

	if err := viper.ReadInConfig(); err != nil {
		log.Fatalf("Config dosyası bulunamadı: %v", err)
	}

	var sites []SiteConfig
	if err := viper.UnmarshalKey("sites", &sites); err != nil {
		log.Fatalf("Siteler yapılandırılamadı: %v", err)
	}

	for {
		fmt.Println("Bir site seçin:")
		for i, site := range sites {
			fmt.Printf("%d: %s\n", i+1, site.Name)
		}
		fmt.Printf("%d: Çıkış\n", len(sites)+1)
		fmt.Print("Seçiminiz: ")

		var choice int
		fmt.Scanln(&choice)

		if choice == len(sites)+1 {
			fmt.Println("Program sonlandırılıyor...")
			break
		}

		if choice < 1 || choice > len(sites) {
			fmt.Println("Geçersiz seçim. Lütfen tekrar deneyin.")
			continue
		}

		selectedSite := sites[choice-1]

		articles := scrapeSite(selectedSite)

		if len(articles) > 0 {
			saveToFile(selectedSite.BaseURL, articles)
			fmt.Printf("%d makale başarıyla kaydedildi.\n", len(articles))
		} else {
			fmt.Println("Hiç makale bulunamadı.")
		}
	}
}

func scrapeSite(config SiteConfig) []Article {
	var articles []Article

	doc, err := goquery.NewDocument(config.BaseURL)
	if err != nil {
		log.Printf("Sayfa çekme hatası: %v", err)
		return articles
	}

	doc.Find(config.ArticleSelector).Each(func(i int, s *goquery.Selection) {
		title := s.Find(config.TitleSelector).Text()
		description := s.Find(config.DescSelector).Text()
		date := s.Find(config.DateSelector).Text()

		if title != "" && description != "" && date != "" {
			articles = append(articles, Article{
				Title:       title,
				Description: description,
				Date:        date,
			})
		}
	})

	return articles
}

func saveToFile(baseURL string, articles []Article) {
	if len(articles) == 0 {
		fmt.Println("Kaydedilecek makale yok!")
		return
	}

	domain := strings.TrimPrefix(baseURL, "https://")
	domain = strings.TrimPrefix(domain, "http://")
	domain = strings.ReplaceAll(domain, "/", "_")
	domain = strings.ReplaceAll(domain, ":", "_") 
	fileName := fmt.Sprintf("%s_articles.txt", domain)

	file, err := os.Create(fileName)
	if err != nil {
		log.Fatalf("Dosya oluşturulamadı: %v", err)
	}
	defer file.Close()

	writer := bufio.NewWriter(file)
	for _, article := range articles {
		_, err := writer.WriteString(fmt.Sprintf("Başlık: %s\nAçıklama: %s\nTarih: %s\n\n", article.Title, article.Description, article.Date))
		if err != nil {
			log.Printf("Dosyaya yazma hatası: %v", err)
		}
	}

	writer.Flush()
	fmt.Printf("Veriler %s dosyasına kaydedildi.\n", fileName)
}
