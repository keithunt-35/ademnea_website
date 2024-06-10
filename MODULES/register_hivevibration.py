import shutil
import register_media

def insert_vibration(csv, filename):
    
    mydb = register_media.database_connection()  # connecting to db
    mycursor = mydb.cursor()  # the cursor helps us execute our queries

    # EXTRACTING DB DETAILS FROM NAME
    hive_id = csv.split("_")[1]  # Assuming the format is vibration_hiveID_timestamp.csv
    created_at = csv.split("_")[2].split(".csv")[0]

    # DB INSERTION
    query = "INSERT INTO hive_vibrations(path, hive_id, created_at) VALUES (%s, %s, %s)"
    data = (filename, hive_id, created_at)

    try:
        # Executing the SQL command
        mycursor.execute(query, data)
        # Commit the changes in the database
        mydb.commit()
    except:
        # Rolling back in case of error
        mydb.rollback()
    # Closing the connection
    mydb.close()

def reg(filename, source_folder):

    csv = filename
    filename = register_media.reconstruct(filename)  # Assuming this function reconstructs the path as needed
    insert_vibration(filename, csv)  # insert csv path into DB

    # TRANSFER TO ANOTHER FOLDER
    src = source_folder + '/' + csv
    new_dest = folder_destination + '/' + csv
    shutil.move(src, new_dest)

folder_destination = r"/var/www/html/ademnea_website/public/hivevibration"