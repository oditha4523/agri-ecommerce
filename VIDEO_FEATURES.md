# Video Upload and Autoplay Feature

## Overview
The Agro Vista platform now supports direct video file uploads for products with automatic playback functionality.

## Features

### Video Upload
- **Add Product**: Video file upload is required when adding new products
- **Edit Product**: Video file upload is optional when editing (keeps existing if not replaced)
- **Supported Formats**: MP4, WebM, OGG, AVI, MOV
- **Storage**: Videos are stored in `/assets/videos/` with unique filenames

### Video Playback
- **Autoplay**: Videos automatically start playing when modal opens
- **Muted Start**: Videos start muted to comply with browser autoplay policies
- **User Interaction**: Click video to unmute
- **Visual Feedback**: Autoplay indicator shows when video starts
- **Responsive**: Videos work on desktop and mobile devices

## File Structure
```
assets/
├── videos/           # Uploaded video files
│   ├── .htaccess    # MIME types and security headers
│   └── [video files]
```

## Database Schema
The `products` table stores video file paths:
```sql
CREATE TABLE `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `seller_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` enum('Utilized','UnderUtilized') NOT NULL,
  `video_url` varchar(255) DEFAULT NULL,  -- Stores: assets/videos/filename.ext
  PRIMARY KEY (`product_id`)
);
```

## User Experience

### Admin Interface
1. **Add Product**: Upload video file via file input
2. **Edit Product**: Optionally replace existing video
3. **File Validation**: Only video formats accepted
4. **Error Handling**: Clear messages for upload issues

### Public Interface
1. **Product Grid**: Shows products with video overlay
2. **Play Button**: Click to open video modal
3. **Autoplay**: Video starts automatically when modal opens
4. **Controls**: Standard video controls available
5. **Close**: Click X or outside modal to close

## Browser Compatibility
- **Autoplay**: Muted autoplay supported in modern browsers
- **Fallback**: Manual play if autoplay is blocked
- **Mobile**: Optimized for mobile video playback
- **MIME Types**: Proper video MIME types configured

## Security
- **File Validation**: Server-side validation of video file types
- **Unique Names**: Prevents filename conflicts and unauthorized access
- **Headers**: Security headers configured in .htaccess

## Performance
- **Preload**: Videos preload metadata for faster startup
- **Compression**: Recommend compressed video files for web
- **Size Limits**: Depends on server PHP configuration
