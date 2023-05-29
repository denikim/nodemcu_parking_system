#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>
#include <Arduino_JSON.h>
#include <SPI.h>
#include <WiFiClient.h>

WiFiClient wifiClient;

#define ON_Board_LED 2 

const char* ssid = "Behzod's phone";
const char* password = "123456789";

ESP8266WebServer server(80);  

byte readcard[4];
char str[32] = "";

String postData = ""; 
String postData1 = ""; 
String payload = ""; 
String payload1 = "";

const int trigPin1 = 5;
const int echoPin1 = 4; 
const int trigPin = 12;  
const int echoPin = 14; 

int httpCode;
int httpCode1;

float duration, distance=10; 
float duration1, distance1=10; 

void setup() {
  Serial.begin(115200);
  SPI.begin(); 

  delay(500);

  WiFi.begin(ssid, password); 
  Serial.println("");

  pinMode(ON_Board_LED, OUTPUT);
  digitalWrite(ON_Board_LED, HIGH); 

  Serial.print("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    digitalWrite(ON_Board_LED, LOW);
    delay(250);
    digitalWrite(ON_Board_LED, HIGH);
    delay(250);
  }
  digitalWrite(ON_Board_LED, HIGH);

  Serial.println("");
  Serial.print("Successfully connected to : ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());

  pinMode(trigPin, OUTPUT);  
	pinMode(echoPin, INPUT);   
  pinMode(trigPin1, OUTPUT);  
	pinMode(echoPin1, INPUT); 

}

void loop() {
   if(WiFi.status()== WL_CONNECTED) {
    digitalWrite(ON_Board_LED, LOW);
    HTTPClient http;

    get_CH_sensor_data();

    postData += "&cm=" + String(distance);
    payload = "";

    digitalWrite(ON_Board_LED, HIGH);
    Serial.println();
    Serial.println("---------------updatedata.php");
    http.begin(wifiClient,"http://192.168.182.107/NodeMCU-parking-system/updateSensorData.php");
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
   
    httpCode = http.POST(postData); 
    payload = http.getString(); 
      
    Serial.print("httpCode : ");
    Serial.println(httpCode); 
    Serial.print("payload  : ");
    Serial.println(payload); 
    http.end();

    postData1 += "&cm=" + String(distance1);
    payload1 = ""; 
    digitalWrite(ON_Board_LED, HIGH);
    Serial.println();
    Serial.println("---------------updatedata.php");
    http.begin(wifiClient,"http://192.168.182.107/NodeMCU-parking-system/update2.php");
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    httpCode1 = http.POST(postData1);
    payload1 = http.getString();  
    

    Serial.print("httpCode1 : ");
    Serial.println(httpCode1); 
    Serial.print("payload1  : ");
    Serial.println(payload1);
    http.end();

    Serial.println("---------------");
    digitalWrite(ON_Board_LED, LOW); 
    delay(3000);
  }
}
void get_CH_sensor_data() {
  Serial.println();
  Serial.println("-------------get_CH_sensor_data()");

  digitalWrite(trigPin, LOW);  
	delayMicroseconds(2);  
	digitalWrite(trigPin, HIGH);  
	delayMicroseconds(10);  
	digitalWrite(trigPin, LOW);

  duration = pulseIn(echoPin, HIGH);
  
  distance = (duration*.0343)/2;
  Serial.printf("Distance : %.2f \n",distance);  

  digitalWrite(trigPin1, LOW);  
	delayMicroseconds(2);  
	digitalWrite(trigPin1, HIGH);  
	delayMicroseconds(10);  
	digitalWrite(trigPin1, LOW);
  duration1 = pulseIn(echoPin1, HIGH);

  distance1 = (duration1*.0343)/2;
  Serial.printf("Distance1 : %.2f \n",distance1);  
	delay(100); 
}
