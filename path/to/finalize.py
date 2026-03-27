import ollama
import pdfkit
import os

def read_file(file_path):
    with open(file_path, 'r', encoding='utf-8') as file:
        return file.read()

def save_pdf(content, output_path):
    config = pdfkit.configuration(wkhtmltopdf='/usr/local/bin/wkhtmltopdf')
    pdfkit.from_string(content, output_path, configuration=config, encoding='latin-1')

def generate_ai_report():
    text = read_file('thema.txt')
    response = ollama.generate(model='qwen2.5:7b', prompt=text)
    save_pdf(response, 'KI_Ergebnis.pdf')
    
    # Windows Notification
    os.system("powershell -Command \"Add-ComputerNotification -Title 'Dein KI-Report ist fertig!' -Message '' -Icon 'Information'\"")

def main():
    generate_ai_report()
    # Automatically open the PDF after saving
    os.system('cmd.exe /c start KI_Ergebnis.pdf')

if __name__ == '__main__':
    main()
