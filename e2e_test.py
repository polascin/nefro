import os
import re
import time
import subprocess
import imaplib
import email
import requests
from bs4 import BeautifulSoup
import configparser

def run_e2e():
    email_addr = f"e2e_{int(time.time())}@it-it.sk"
    password = "Password123!"
    
    results = {
        "E2E_EMAIL": email_addr,
        "IMAP_LOGIN_OK": False,
        "STEP_REGISTER_OK": False,
        "STEP_MAIL_FOUND_OK": False,
        "STEP_VERIFY_LINK_EXTRACT_OK": False,
        "STEP_VERIFY_OPEN_OK": False,
        "STEP_LOGIN_AFTER_VERIFY_OK": False,
        "STEP_HEADER_BADGE_OK": False,
        "REASON": ""
    }
    
    # 1. Parse env.ini
    config = configparser.ConfigParser()
    try:
        with open("env.ini", "r") as f:
            content = "[env]\n" + f.read()
        config.read_string(content)
        smtp_user = config.get("env", "SMTP_USER").strip("'\"")
        smtp_pass = config.get("env", "SMTP_PASS").strip("'\"")
    except Exception as e:
        results["REASON"] = f"Config error: {e}"
        return results

    # 2. Start PHP server
    php_proc = subprocess.Popen(["php", "-S", "127.0.0.1:8122", "-t", "d:\\OneDrive\\www\\nefro"], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
    time.sleep(1)
    
    session = requests.Session()
    base_url = "http://127.0.0.1:8122"
    
    try:
        # 3. IMAP Login Check
        try:
            mail = imaplib.IMAP4_SSL("imap.m1.websupport.sk", 993)
            mail.login(smtp_user, smtp_pass)
            results["IMAP_LOGIN_OK"] = True
            mail.logout()
        except Exception as e:
            results["REASON"] = f"IMAP error: {e}"
            return results

        # 4. Register
        r = session.get(f"{base_url}/register.php")
        soup = BeautifulSoup(r.text, "html.parser")
        csrf_token = soup.find("input", {"name": "csrf_token"})["value"]
        
        reg_data = {
            "csrf_token": csrf_token,
            "username": "e2e_user_" + str(int(time.time())),
            "email": email_addr,
            "password": password,
            "newsletter_consent": "0",
            "first_name": "E2E",
            "last_name": "Test",
            "street": "Street",
            "house_number": "1",
            "zip_code": "12345",
            "city": "City",
            "district": "District",
            "region": "Region",
            "country": "Slovakia",
        }
        
        r = session.post(f"{base_url}/register.php", data=reg_data)
        if "Registrácia prebehla úspešne" in r.text and "overiť e-mailovú adresu" in r.text:
            results["STEP_REGISTER_OK"] = True
        else:
            results["REASON"] = "Registration failed"
            return results

        # 5. Poll IMAP for mail
        verify_url = None
        start_time = time.time()
        while time.time() - start_time < 120:
            try:
                mail = imaplib.IMAP4_SSL("imap.m1.websupport.sk", 993)
                mail.login(smtp_user, smtp_pass)
                mail.select("INBOX")
                type, data = mail.search(None, "ALL")
                ids = data[0].split()
                if ids:
                    for latest_id in reversed(ids[-30:]):
                        type, data = mail.fetch(latest_id, "(RFC822)")
                        msg = email.message_from_bytes(data[0][1])

                        msg_to = str(msg.get("To", ""))
                        msg_subject = str(msg.get("Subject", ""))

                        body = ""
                        if msg.is_multipart():
                            for part in msg.walk():
                                ctype = part.get_content_type()
                                if ctype in ("text/plain", "text/html"):
                                    payload = part.get_payload(decode=True)
                                    if payload:
                                        body += payload.decode(errors="ignore") + "\n"
                        else:
                            payload = msg.get_payload(decode=True)
                            if payload:
                                body = payload.decode(errors="ignore")

                        if email_addr not in msg_to and email_addr not in body:
                            continue

                        results["STEP_MAIL_FOUND_OK"] = True
                        match = re.search(r'https?://[^\s<>"]+verify_email\.php[^\s<>"]+', body)
                        if not match:
                            match = re.search(r'https?://[^\s<>"]+verify_email\.php[^\s<>"]+', msg_subject)
                        if match:
                            verify_url = match.group(0).replace("&amp;", "&")
                            results["STEP_VERIFY_LINK_EXTRACT_OK"] = True
                            break
                    if verify_url:
                        mail.logout()
                        break
                mail.logout()
            except Exception:
                pass
            time.sleep(10)
        
        if not verify_url:
            results["REASON"] = "Verification link not found in time"
            return results

        # 6. Open Verification Link
        # Adjust URL to point to localhost if the link uses a real domain
        verify_url = re.sub(r'https?://[^/]+', base_url, verify_url)
        r = session.get(verify_url)
        if "úspešne overená" in r.text or "je už overená" in r.text:
            results["STEP_VERIFY_OPEN_OK"] = True
        else:
            results["REASON"] = "Verification page error"
            return results

        # 7. Login
        r = session.get(f"{base_url}/login.php")
        soup = BeautifulSoup(r.text, "html.parser")
        csrf_token = soup.find("input", {"name": "csrf_token"})["value"]
        
        login_data = {
            "csrf_token": csrf_token,
            "login": email_addr,
            "password": password
        }
        r = session.post(f"{base_url}/login.php", data=login_data, allow_redirects=True)
        if "Odhlásiť" in r.text or "Profil" in r.text:
            results["STEP_LOGIN_AFTER_VERIFY_OK"] = True
        else:
            results["REASON"] = "Login failed after verification"
            return results

        # 8. Check Badge
        r = session.get(f"{base_url}/index.php")
        if "E-mail overený" in r.text:
            results["STEP_HEADER_BADGE_OK"] = True
        else:
            results["REASON"] = "Badge 'E-mail overený' not found"

    finally:
        php_proc.terminate()
        
    return results

if __name__ == "__main__":
    res = run_e2e()
    for k, v in res.items():
        print(f"{k}={v}")
