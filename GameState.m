//
//  GameState.m
//  HopingForAWish
//
//  Created by Austin Chan on 12/4/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import "GameState.h"

@implementation GameState{
    NSString *userID;
    NSArray *selectionChoices;
}

@synthesize storage;

+ (GameState *)sharedGameState
{
    static GameState *sharedGameState;
    
    @synchronized(self)
    {
        if (!sharedGameState)
            sharedGameState = [[GameState alloc] init];
        
        return sharedGameState;
    }
}

- (id)init
{
    self = [super init];
    if (self) {
        storage = [[NSMutableDictionary alloc] init];
    }
    return self;
}

- (void)setUserID:(NSString *)number{
    userID = number;
    
    [storage setObject:number forKey:@"userID"];
    
    [self save];
}
- (NSString *)getUserID{
    return userID;
}

- (void)setSelectionChoices:(NSArray *)choices{
    selectionChoices = choices;
    
    [storage setObject:choices forKey:@"selectionChoices"];
    
    [self save];

}

- (void)saveStage:(NSString *)stage{
    [storage setObject:stage forKey:@"stage"];
    [self save];
}
- (NSString *)getStage{
    return [storage objectForKey:@"stage"];
}
- (NSArray *)getSelectionChoices{
    return selectionChoices;
}


- (void)save{
    NSError *error;
    NSData *data = [NSJSONSerialization dataWithJSONObject:storage options:0 error:&error];
    
    NSString *docDir = [NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES) objectAtIndex:0];
    NSString *docFile = [docDir stringByAppendingPathComponent:@"store.txt"];

    // Save data written
    [data writeToFile:docFile atomically:NO];
}

- (void)load{
    NSString *docDir = [NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES) objectAtIndex:0];
    NSString *docFile = [docDir stringByAppendingPathComponent:@"store.txt"];

    BOOL fileExists = [[NSFileManager defaultManager] fileExistsAtPath:docFile];
    
    if(fileExists){
        NSError *error;
        NSData *data = [NSData dataWithContentsOfFile:docFile options:NSUTF8StringEncoding error:&error];
        
        // Save data read
        storage = [[NSJSONSerialization JSONObjectWithData:data options:NSUTF8StringEncoding error:&error] mutableCopy];
    }
    
    [self loadStorage];

}

- (void)loadStorage{
    if([storage objectForKey:@"userID"]){
        userID = [storage objectForKey:@"userID"];
    }
    if([storage objectForKey:@"selectionChoices"]){
        selectionChoices = [storage objectForKey:@"selectionChoices"];
    }
    
}

@end
