import PIL.Image as Image
import sqlite3
import os

def crop_pics(dbname):
  conn = sqlite3.connect(dbname)
  c = conn.cursor()
  pos_count = 0
  neg_count = 0

  id2path = [row for row in c.execute('SELECT * FROM images')]
  id2path = [(x, y) for (x, y, z) in id2path]
  path_dict = dict(id2path)

  for row in c.execute('SELECT * FROM boxes'):
    box_id, is_pos, pic_id, fx, fy, sx, sy = row
    filename = path_dict[pic_id]
    if is_pos:
      outname = 'pos/pos_%d_%s_%0.4f_%0.4f.jpg' % (pos_count, os.path.splitext(os.path.basename(filename))[0], fx, fy )
      pos_count += 1
    else:
      outname = 'neg/neg_%d_%s_%0.4f_%0.4f.jpg' % (neg_count, os.path.splitext(os.path.basename(filename))[0], fx, fy)
      neg_count += 1
    im = Image.open(filename)
    w, h = im.size
    fx = int(fx * w)
    fy = int(fy * h)
    sx = int(sx * w)
    sy = int(sy * h)
    im.crop((fx, fy, sx, sy)).save(outname)

  return (pos_count, neg_count)

print('pos: %d, neg: %d\n' % crop_pics("my_database.db"))