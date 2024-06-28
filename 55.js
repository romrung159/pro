async function fetchData() {
    try {
      const response = await fetch('https://dld.dpis.go.th/service4notification '); // แทน URL API ที่ถูกต้อง
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      const data = await response.json();
      console.log(data); // แสดงข้อมูลทั้งหมดใน console
      
      // ตัวอย่างการแสดงข้อมูลบางส่วน
      console.log('จำนวนบุคลากรทั้งหมด:', data.totalPersonnel);
      console.log('จำนวนข้าราชการ:', data.civilServants);
      console.log('จำนวนลูกจ้าง:', data.employees);
      // ... แสดงข้อมูลอื่นๆ ตามต้องการ
    } catch (error) {
      console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', error);
    }
  }
  
  fetchData();