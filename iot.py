import serial
import oracledb
from datetime import datetime

# ✅ Enable Thick Mode with your Instant Client path
oracledb.init_oracle_client(lib_dir=r"C:\instantclient_21_3")

# Oracle DB Connection
DB_USER = "ecommerce"
DB_PASS = "ecommerce"
DB_CONN = "localhost/xe"  # Use XE for Oracle Express Edition

def get_serial_uid():
    try:
        arduino = serial.Serial('COM4', 9600, timeout=10)
        print("Waiting for RFID UID scan...")
        while True:
            line = arduino.readline().decode('utf-8').strip()
            if line.startswith("Scanned UID:"):
                uid = line.replace("Scanned UID:", "").strip()
                arduino.close()
                return uid
    except serial.SerialException as e:
        print(f"Error reading serial port: {e}")
        return None

def check_uid_exists(cursor, uid):
    cursor.execute(
        "SELECT COUNT(*) FROM PRODUCT WHERE PRODUCT_NAME = :1",
        (uid,)
    )
    result = cursor.fetchone()
    return result[0] > 0

def insert_product(cursor, uid):
    print("\nEnter product details:")
    # We're using the UID as the product name
    product_name = input("Product name: ")

    product_desc     = input("Product Description: ")
    product_rating   = input("Product Rating: ")
    display_type     = input("Display Type: ")
    quantity         = int(input("Quantity: "))
    stock            = input("Stock (e.g. 'In Stock'): ")
    allergy_info     = input("Allergy Info (optional): ")
    product_price    = float(input("Product Price: "))
    shop_id          = int(input("Shop ID (FK1_SHOP_ID): "))
    image_path       = input("Image path or URL (max 255 chars): ").strip()

    cursor.execute("""
        INSERT INTO PRODUCT (
            PRODUCT_IMAGE,
            PRODUCT_RATING,
            PRODUCT_NAME,
            PRODUCT_DESC,
            ALLERGY_INFO,
            PRODUCT_PRICE,
            DISPLAY_TYPE,
            QUANTITY,
            STOCK,
            FK1_SHOP_ID
        ) VALUES (
            :image_path,
            :product_rating,
            :product_name,
            :product_desc,
            :allergy_info,
            :product_price,
            :display_type,
            :quantity,
            :stock,
            :shop_id
        )
    """, {
        'image_path':      image_path,
        'product_rating':  product_rating,
        'product_name':    product_name,
        'product_desc':    product_desc,
        'allergy_info':    allergy_info if allergy_info else None,
        'product_price':   product_price,
        'display_type':    display_type,
        'quantity':        quantity,
        'stock':           stock,
        'shop_id':         shop_id
    })

def main():
    try:
        conn = oracledb.connect(user=DB_USER, password=DB_PASS, dsn=DB_CONN)
        cursor = conn.cursor()
        print("✅ Connected to Oracle DB successfully.")
    except oracledb.DatabaseError as e:
        print(f"❌ Database connection error: {e}")
        return

    try:
        while True:
            uid = get_serial_uid()
            if not uid:
                print("⚠️ No UID read. Try again.")
                continue

            print(f"\n📟 Scanned UID (used as Product Name): {uid}")

            if check_uid_exists(cursor, uid):
                print("⚠️  Item already exists. Use a different product name.")
            else:
                print("✅ New item. Let's add the product.")
                insert_product(cursor, uid)
                conn.commit()
                print("🎉 Product inserted successfully.")

            cont = input("\nScan another? (y/n): ")
            if cont.strip().lower() != 'y':
                break

    except KeyboardInterrupt:
        print("\n🛑 Process interrupted by user.")

    finally:
        cursor.close()
        conn.close()
        print("🔒 Connection closed.")

if __name__ == "__main__":
    main()
