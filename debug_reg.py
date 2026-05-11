import requests
from bs4 import BeautifulSoup
import time
import subprocess
import re

php_proc = subprocess.Popen(["php", "-S", "127.0.0.1:8122", "-t", "."], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
time.sleep(1)
session = requests.Session()
r = session.get("http://127.0.0.1:8122/register.php")
soup = BeautifulSoup(r.text, "html.parser")
csrf_token = soup.find("input", {"name": "csrf_token"})["value"]

reg_data = {
    "csrf_token": csrf_token,
    "username": "debug_user_" + str(int(time.time())),
    "email": f"debug_{int(time.time())}@it-it.sk",
    "password": "Password123!",
    "confirm_password": "Password123!",
    "first_name": "Debug",
    "last_name": "User",
    "street": "Street",
    "house_number": "1",
    "zip_code": "12345",
    "city": "City",
    "district": "District",
    "region": "Region",
    "country": "Slovakia",
    "terms_acceptance": "on"
}
r = session.post("http://127.0.0.1:8122/register.php", data=reg_data)

soup_after = BeautifulSoup(r.text, "html.parser")
alerts = soup_after.find_all(class_=re.compile("alert|error|danger"))
if alerts:
    for a in alerts:
        print("ALERT:", a.text.strip())
else:
    print("NO ALERTS FOUND")
    if "úspešne zaregistrovaný" in r.text:
        print("Success message found")
    else:
        print("Success message NOT found")

php_proc.terminate()
