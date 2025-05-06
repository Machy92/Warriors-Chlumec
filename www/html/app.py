from flask import Flask, render_template
from bs4 import BeautifulSoup
from datetime import datetime

app = Flask(__name__)

html_content = """
<div class="col-12 col-md-4 col-lg-3 mb-4"> 
							<div class="d-flex align-items-center position-relative">  
								<div class="thumb thumb-48x48 overflow-hidden rounded-circle d-flex align-items-center">  
									<img data-src="https://is.cmshb.cz/data/member/photo/7982543092a37555f61ba61ffb06b44e.jpg" width="48" height="58" alt="" class="lazy js-lazy d-block loaded" src="https://is.cmshb.cz/data/member/photo/7982543092a37555f61ba61ffb06b44e.jpg">    
								</div>
								<div class="ml-6">        
									<a href="/hrac?id=47357&amp;team=14910" class="d-block text-decoration-none stretched-link font-weight-bold mb-1">	
										Nikita Fomov       
									</a>        
									<div class="">
										18. 09. 2002
									</div>    
								</div>
							</div>                        
						</div>"""

def extract_players():
    soup = BeautifulSoup(html_content, "html.parser")
    players_data = []
    players = soup.find_all("div", class_="col-12 col-md-4 col-lg-3 mb-4")

    for player in players:
        # Získání jména hráče
        name_element = player.find("a", class_="d-block text-decoration-none")
        if name_element:
            name = name_element.text.strip()
        else:
            name = "Není k dispozici"  # Pokud jméno není dostupné
        
        # Získání data narození
        birth_date_element = player.find("div", class_="")
        if birth_date_element:
            birth_date = birth_date_element.text.strip()
        else:
            birth_date = "Není k dispozici"  # Pokud datum není dostupné

        # Výpočet věku
        try:
            birth_date_obj = datetime.strptime(birth_date, "%d. %m. %Y")
            age = datetime.today().year - birth_date_obj.year
            if (datetime.today().month, datetime.today().day) < (birth_date_obj.month, birth_date_obj.day):
                age -= 1
        except ValueError:
            age = "Není k dispozici"  # Pokud není správně formátované datum

        players_data.append({"name": name, "birth_date": birth_date, "age": age})
    
    return players_data

@app.route('/')
def index():
    players = extract_players()
    return render_template('index.html', players=players)

if __name__ == "__main__":
    app.run(debug=True)
