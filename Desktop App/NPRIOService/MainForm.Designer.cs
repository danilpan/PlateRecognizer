namespace NPRIOService
{
    partial class MainForm
    {
        /// <summary>
        /// Обязательная переменная конструктора.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Освободить все используемые ресурсы.
        /// </summary>
        /// <param name="disposing">истинно, если управляемый ресурс должен быть удален; иначе ложно.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Код, автоматически созданный конструктором форм Windows

        /// <summary>
        /// Требуемый метод для поддержки конструктора — не изменяйте 
        /// содержимое этого метода с помощью редактора кода.
        /// </summary>
        private void InitializeComponent()
        {
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(MainForm));
            this.panel1 = new System.Windows.Forms.Panel();
            this.crmUrl_tb = new System.Windows.Forms.TextBox();
            this.cameraIP_tb = new System.Windows.Forms.TextBox();
            this.label1 = new System.Windows.Forms.Label();
            this.label2 = new System.Windows.Forms.Label();
            this.start_btn = new System.Windows.Forms.Button();
            this.logs_tb = new System.Windows.Forms.RichTextBox();
            this.macAddress_tb = new System.Windows.Forms.TextBox();
            this.label3 = new System.Windows.Forms.Label();
            this.label4 = new System.Windows.Forms.Label();
            this.stop_btn = new System.Windows.Forms.Button();
            this.SuspendLayout();
            // 
            // panel1
            // 
            this.panel1.AutoSize = true;
            this.panel1.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D;
            this.panel1.Dock = System.Windows.Forms.DockStyle.Left;
            this.panel1.Location = new System.Drawing.Point(0, 0);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(4, 568);
            this.panel1.TabIndex = 7;
            // 
            // crmUrl_tb
            // 
            this.crmUrl_tb.Font = new System.Drawing.Font("Microsoft Sans Serif", 16.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
            this.crmUrl_tb.Location = new System.Drawing.Point(28, 38);
            this.crmUrl_tb.Name = "crmUrl_tb";
            this.crmUrl_tb.Size = new System.Drawing.Size(318, 38);
            this.crmUrl_tb.TabIndex = 8;
            this.crmUrl_tb.Text = "127.0.0.1:8000";
            // 
            // cameraIP_tb
            // 
            this.cameraIP_tb.Font = new System.Drawing.Font("Microsoft Sans Serif", 16.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
            this.cameraIP_tb.Location = new System.Drawing.Point(28, 110);
            this.cameraIP_tb.Name = "cameraIP_tb";
            this.cameraIP_tb.Size = new System.Drawing.Size(318, 38);
            this.cameraIP_tb.TabIndex = 9;
            this.cameraIP_tb.Text = "192.168.1.100:8080";
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Font = new System.Drawing.Font("Microsoft Sans Serif", 10.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
            this.label1.Location = new System.Drawing.Point(24, 10);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(86, 20);
            this.label1.TabIndex = 10;
            this.label1.Text = "CRM URL";
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Font = new System.Drawing.Font("Microsoft Sans Serif", 10.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
            this.label2.Location = new System.Drawing.Point(24, 87);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(88, 20);
            this.label2.TabIndex = 11;
            this.label2.Text = "Camera IP";
            // 
            // start_btn
            // 
            this.start_btn.Location = new System.Drawing.Point(28, 480);
            this.start_btn.Name = "start_btn";
            this.start_btn.Size = new System.Drawing.Size(127, 44);
            this.start_btn.TabIndex = 12;
            this.start_btn.Text = "Start";
            this.start_btn.UseVisualStyleBackColor = true;
            this.start_btn.Click += new System.EventHandler(this.start_btn_Click);
            // 
            // logs_tb
            // 
            this.logs_tb.Location = new System.Drawing.Point(398, 38);
            this.logs_tb.Name = "logs_tb";
            this.logs_tb.Size = new System.Drawing.Size(738, 518);
            this.logs_tb.TabIndex = 13;
            this.logs_tb.Text = "";
            // 
            // macAddress_tb
            // 
            this.macAddress_tb.Font = new System.Drawing.Font("Microsoft Sans Serif", 16.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
            this.macAddress_tb.Location = new System.Drawing.Point(28, 183);
            this.macAddress_tb.Name = "macAddress_tb";
            this.macAddress_tb.Size = new System.Drawing.Size(318, 38);
            this.macAddress_tb.TabIndex = 14;
            this.macAddress_tb.Text = "12:34:56:78";
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Font = new System.Drawing.Font("Microsoft Sans Serif", 10.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
            this.label3.Location = new System.Drawing.Point(24, 160);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(175, 20);
            this.label3.TabIndex = 15;
            this.label3.Text = "Camera MAC address";
            // 
            // label4
            // 
            this.label4.AutoSize = true;
            this.label4.Font = new System.Drawing.Font("Microsoft Sans Serif", 10.2F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
            this.label4.Location = new System.Drawing.Point(732, 10);
            this.label4.Name = "label4";
            this.label4.Size = new System.Drawing.Size(46, 20);
            this.label4.TabIndex = 16;
            this.label4.Text = "Logs";
            // 
            // stop_btn
            // 
            this.stop_btn.Location = new System.Drawing.Point(217, 480);
            this.stop_btn.Name = "stop_btn";
            this.stop_btn.Size = new System.Drawing.Size(129, 44);
            this.stop_btn.TabIndex = 17;
            this.stop_btn.Text = "Stop";
            this.stop_btn.UseVisualStyleBackColor = true;
            this.stop_btn.Click += new System.EventHandler(this.stop_btn_Click);
            // 
            // MainForm
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(8F, 16F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = System.Drawing.Color.White;
            this.ClientSize = new System.Drawing.Size(1148, 568);
            this.Controls.Add(this.stop_btn);
            this.Controls.Add(this.label4);
            this.Controls.Add(this.label3);
            this.Controls.Add(this.macAddress_tb);
            this.Controls.Add(this.logs_tb);
            this.Controls.Add(this.start_btn);
            this.Controls.Add(this.label2);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.cameraIP_tb);
            this.Controls.Add(this.crmUrl_tb);
            this.Controls.Add(this.panel1);
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.Name = "MainForm";
            this.Text = "NPR-IOService";
            this.FormClosing += new System.Windows.Forms.FormClosingEventHandler(this.Form1_FormClosing);
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion
        private System.Windows.Forms.Panel panel1;
        private System.Windows.Forms.TextBox crmUrl_tb;
        private System.Windows.Forms.TextBox cameraIP_tb;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.Button start_btn;
        private System.Windows.Forms.RichTextBox logs_tb;
        private System.Windows.Forms.TextBox macAddress_tb;
        private System.Windows.Forms.Label label3;
        private System.Windows.Forms.Label label4;
        private System.Windows.Forms.Button stop_btn;
    }
}

