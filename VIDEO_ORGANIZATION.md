# Video Organization Structure

## Directory Structure for Videos

The video assets are organized in the following structure:

```
assets/
└── videos/
    └── products/
        ├── utilized/
        │   ├── cinnamon/
        │   ├── kithul/
        │   ├── tea/
        │   └── dry_fish/
        └── underutilized/
```

## Video Storage Guidelines

### For Utilized Products:
- **Cinnamon videos**: `/assets/videos/products/utilized/cinnamon/`
- **Kithul videos**: `/assets/videos/products/utilized/kithul/`
- **Tea videos**: `/assets/videos/products/utilized/tea/`
- **Dry Fish videos**: `/assets/videos/products/utilized/dry_fish/`

### For Underutilized Products:
- **Underutilized fruit videos**: `/assets/videos/products/underutilized/`

All underutilized fruit videos are stored directly in the underutilized folder without subcategories.

## Supported Video Formats

The system supports the following video formats:
- MP4 (recommended)
- WebM
- OGG
- AVI
- MOV

## Video URL Handling

The system automatically detects and handles different types of video URLs:

1. **YouTube URLs**: Embeds using YouTube player (click to play)
2. **Vimeo URLs**: Embeds using Vimeo player (click to play)
3. **Local Videos**: Plays using HTML5 video player (click to play)
4. **Other URLs**: Falls back to iframe embedding

### Video Playback Behavior

- **Click to Open**: Video overlay appears only on product images, not the entire page
- **Modal Playback**: Videos start playing automatically when modal opens after user clicks play button
- **Contained Overlay**: Play button overlay is constrained to the product image area
- **Muted by Default**: Local videos are muted by default to comply with browser policies
- **Responsive**: Video players adapt to different screen sizes
- **User Initiated**: Videos only open when user specifically clicks the play button on product images

## How to Store Videos

### When uploading new videos:

1. **Determine the category**: 
   - Utilized products (cinnamon, kithul, tea, dry_fish)
   - Underutilized products

2. **Place the video file** in the appropriate folder:
   ```
   /assets/videos/products/[utilized|underutilized]/[category]/filename.mp4
   ```

3. **Database entry**: Store the video URL in one of these formats:
   - Full relative path: `assets/videos/products/utilized/cinnamon/video.mp4`
   - Filename only: `video.mp4` (system will auto-detect category)
   - Full path with ../: `../assets/videos/products/utilized/cinnamon/video.mp4`

## Example Video URLs in Database

```sql
-- For a cinnamon product video
INSERT INTO products (name, video_url, category) VALUES 
('Ceylon Cinnamon Sticks', 'assets/videos/products/utilized/cinnamon/cinnamon_demo.mp4', 'Utilized');

-- Or just the filename (system will auto-categorize based on product category)
INSERT INTO products (name, video_url, category) VALUES 
('Ceylon Cinnamon Sticks', 'cinnamon_demo.mp4', 'Utilized');

-- For YouTube videos
INSERT INTO products (name, video_url, category) VALUES 
('Ceylon Cinnamon Guide', 'https://www.youtube.com/watch?v=VIDEO_ID', 'Utilized');
```

## Video Auto-categorization

When a video URL contains only a filename (e.g., `video.mp4`), the system automatically places it in the appropriate category folder based on:

1. **Product name matching**: If the product name contains category keywords
2. **Current page context**: The category page being viewed
3. **Default fallback**: Based on the product's category field

## Benefits of This Structure

1. **Organized storage**: Videos are logically grouped by category
2. **Easy maintenance**: Clear folder structure for managing video files
3. **Scalable**: Easy to add new categories or subcategories
4. **Performance**: Efficient video serving and caching
5. **Flexibility**: Supports both local and external video sources
