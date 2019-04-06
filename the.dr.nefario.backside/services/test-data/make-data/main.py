import csv
import random


def get_cat_data():
    with open(r'C:\Users\barraud\Documents\tech\the-map-app-project\the.dr.nefario.backside\services\test-data\cat-list.txt', 'r') as csv_file:
        return {int(x[0]):x[1] for x in csv.reader(csv_file)}


def get_area_data():
    with open(r'C:\Users\barraud\Documents\tech\the-map-app-project\the.dr.nefario.backside\services\test-data\area-list.txt', 'r') as csv_file:
        return {int(x[0]):x[1] for x in csv.reader(csv_file)}


# we are creating one record (at a time) for an estab - FK to area table
# each estab has one area and let's say 1 to 3 (randomly) categories - FK to est_cat

def get_cat_ids():
    cat_ids = []
    how_many = random.randint(1, 4)
    for i in range(1, how_many):
        cat_ids.append(random.randint(1, 16))
    # use set since we want a unique list of cat ids
    return list(set(cat_ids))

def main():
    cat_data = get_cat_data()
    area_data = get_area_data()
    cat_ids = get_cat_ids()
    if len(cat_ids) > 0:
        area_id = random.randint(1, 7)
        print("insert into establishment values({}")
        print(area_id)
        print(cat_ids)



if __name__ == '__main__':
    main()
