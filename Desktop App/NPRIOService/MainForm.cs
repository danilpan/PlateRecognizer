using System;
using System.IO;
using System.IO.Ports;
using System.Net;
using System.Text;
using System.Threading;
using System.Windows.Forms;
using System.Security.Cryptography;
using System.Net.Http;

namespace NPRIOService
{
    public partial class MainForm : Form
    {
        private static string _macAddress;
        private static string _imageUrl;
        private static string _crmUrl;
        private static readonly string imagePath =
            Path.GetDirectoryName(Application.ExecutablePath) + "/photo.jpg";
        private static SerialPort _port;

        public MainForm()
        {
            InitializeComponent();
            _comPortMonitor = new Thread(transportMonitor);
        }

        private void Form1_FormClosing(object sender, FormClosingEventArgs e)
        {
            if (_port != null && _port.IsOpen) _port.Close();
            Environment.Exit(1);
        }

        private void start_btn_Click(object sender, EventArgs e)
        {
            _macAddress = macAddress_tb.Text;
            _imageUrl = "http://" + cameraIP_tb.Text;
            _crmUrl = "http://" + crmUrl_tb.Text + "/recognize";
            if (_comPortMonitor.IsAlive)
                richTextBoxSetValue("Service is already running. Please stop it first.");
            else
            {
                _comPortMonitor = new Thread(transportMonitor);
                _comPortMonitor.Start();
            }
                
        }

        private void stop_btn_Click(object sender, EventArgs e)
        {
            _comPortMonitor.Abort();
            richTextBoxSetValue("Service is stopped");
        }

        public static string calcMD5(string input)
        {
            using (MD5 md5 = MD5.Create())
            {
                byte[] inputBytes = System.Text.Encoding.ASCII.GetBytes(input);
                byte[] hashBytes = md5.ComputeHash(inputBytes);
                StringBuilder sb = new StringBuilder();
                for (int i = 0; i < hashBytes.Length; i++)
                {
                    sb.Append(hashBytes[i].ToString("X2"));
                }
                return sb.ToString();
            }
        }

        protected static string getPortName()
        {
            var portNames = SerialPort.GetPortNames();
            foreach (var portName in portNames)
            {
                _port = new SerialPort(portName);
                try
                {
                    _port.Open();
                    _port.Close();
                    return portName;
                }
                catch (Exception)
                {
                    // ignored
                }
            }
            return "COM0";
        }


        private  void UploadAsync()
        {
            HttpContent bytesContent;
            try
            {
                using (var client = new WebClient())
                {
                    client.DownloadFile(_imageUrl, imagePath);
                }
                byte[] fileBytes = File.ReadAllBytes(imagePath);
                bytesContent = new ByteArrayContent(fileBytes, 0, fileBytes.Length);
            }

            catch(Exception)
            {
                richTextBoxSetValue("Camera is not plugged or can't connect");
                return;
            }

            using (var client = new HttpClient())
            {
                client.DefaultRequestHeaders.Add("hash", calcMD5(_macAddress));
                using (var formData = new MultipartFormDataContent())
                {
                    formData.Add(bytesContent, "car_image", "image.jpg");
                    var response = client.PostAsync(_crmUrl, formData).Result;
                    var s = response.Content.ReadAsStringAsync().Result;
                    if (s.Equals("Error"))
                    {
                        richTextBoxSetValue("Transport is not allowed to pass");
                    }
                    else
                    {
                        richTextBoxSetValue("Transport is passed");
                    }
                }
            }    
        }

        //Transport Monitoring Thread
        private Thread _comPortMonitor;
        protected delegate void setValue(string value);

        public void richTextBoxSetValue(string value)
        {
            if (this.InvokeRequired) this.Invoke(new setValue(richTextBoxSetValue), value);
            else this.logs_tb.Text += value + "\n";
        }

        protected void transportMonitor()
        {
            richTextBoxSetValue("Started.");
            string portName = getPortName();
            if (portName != "COM0")
            {
                _port = new SerialPort(portName, 9600, Parity.None, 8, StopBits.One);
                _port.Open();
                richTextBoxSetValue("Port opened.");
                while (true)
                {
                    string s = _port.ReadLine();
                    if (s.Contains("1"))
                    {
                        richTextBoxSetValue("Transport is detected");
                        try
                        {
                            UploadAsync();
                        }
                        catch (Exception e)
                        {
                            richTextBoxSetValue(e.Message);
                        }
                        finally
                        {
                            Thread.Sleep(5000);
                        }
                    }
                    else
                    {
                        Thread.Sleep(5000);
                    }
                }
            }
            richTextBoxSetValue("Can't find serial port and connect to sensor.");
            richTextBoxSetValue("Finished.");
        }
    }
}
