from ultralytics import YOLO
import supervision as sv
import cv2

model = YOLO('bee_detection_model.pt')

# Read the image
image = cv2.imread('2_2024-06-17_122920.jpg')

# Remove or comment out the resizing step
# resized_image = cv2.resize(image, (640, 640))

# Pass the original image to the model
result = model(image)[0]

# If tracker is enabled
result = model.track(image)[0]

detections = sv.Detections.from_ultralytics(result)

# Extract the number of detected bees
num_bees = len(detections)

# Print the count of detected bees
print(f"Number of detected bees: {num_bees}")